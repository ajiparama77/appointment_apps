<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Nonstandard\Uuid;

use function Symfony\Component\Clock\now;

class Appointment extends Model{

    public $table = 'appointment';
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    public $keyType = 'string';

    protected $guarded = [];


    static function getMyInvitation()
{
    date_default_timezone_set(auth('api')->user()->preffered_timezone);
    $now       = now();
    $uuid_user = auth('api')->user()->uuid;

    $data= DB::table('detail_appointment')
        ->where('detail_appointment.invite_to', $uuid_user)
        ->join('appointment', 'appointment.uuid', '=', 'detail_appointment.appointment_id')
        ->join('users', 'users.uuid', '=', 'appointment.creator_id') 
        ->select(
            'appointment.uuid',
            'appointment.title',
            'appointment.start',
            'appointment.end',
            'appointment.timezone_location',
            'users.name AS creator'
        )
        ->get();
        $response = [];
        foreach($data as $index){
            $start  = Carbon::parse($index->start);
            $end    = Carbon::parse($index->end);

            if ($now < $start) {
                $status = 'On schedulled';
            } elseif ($now >= $start && $now <= $end) {
                $status = 'On going';
            } else {
                $status = 'Done';
            }

            $response[] = [
                'uuid'      => $index->uuid,
                'title'     => $index->title,
                'creator'   => $index->creator,
                'status'    => $status
            ];
        }

      
        return $response;

}


static function getMyAppointment()
{
    date_default_timezone_set(auth('api')->user()->preffered_timezone);
    $now  = now();
    $user = auth('api')->user();

 
    $myAppointment = self::where('creator_id', $user->uuid)
        ->join('users', 'users.uuid', '=', 'appointment.creator_id')
        ->select(
            'appointment.uuid',
            'appointment.title',
            'appointment.start',
            'appointment.end',
            'appointment.timezone_location',
            'users.name AS creator'
        )
        ->get();
  

        $res = [];
        foreach($myAppointment as $index){
            $start  = Carbon::parse($index->start);
            $end    = Carbon::parse($index->end);

            if ($now < $start) {
                $status = 'On schedulled';
            } elseif ($now >= $start && $now <= $end) {
                $status = 'On going';
            } else {
                $status = 'Done';
            }

            $res[] = [
                'uuid'      => $index->uuid,
                'title'     => $index->title,
                'creator'   => $index->creator,
                'status'    => $status
            ];
        }

        $myInvitations = self::getMyInvitation();
        $list = array_merge($res,$myInvitations);

        return $list;
}


    static function detailAppointments($uuid)
{
    $output = [];

    $response = Appointment::where('appointment.uuid', $uuid)
        ->select('appointment.start', 'appointment.end')
        ->first();

    if ($response) {
        // anggap di DB sudah UTC
        $startUtc = Carbon::parse($response->start)->setTimezone('UTC');
        $endUtc   = Carbon::parse($response->end)->setTimezone('UTC');

        $users = DB::table('detail_appointment')
            ->where('appointment_id', $uuid)
            ->join('users', 'users.uuid', '=', 'detail_appointment.invite_to')
            ->select('users.uuid', 'users.name', 'users.preffered_timezone')
            ->get();

        foreach ($users as $index) {
            $userTz = $index->preffered_timezone;

          
            $startLocal = (clone $startUtc)->setTimezone($userTz);
            $endLocal   = (clone $endUtc)->setTimezone($userTz);

           
            $startHour = (int) $startLocal->format('H');
            $endHour   = (int) $endLocal->format('H');
            $isWithinWorkingHours = $startHour >= 9 && $endHour <= 17;

            $output[] = [
                'user_uuid'  => $index->uuid,
                'name'       => $index->name,
                'timezone'   => $userTz,
                'start_utc'  => $startUtc->toIso8601String(),   
                'end_utc'    => $endUtc->toIso8601String(),
                'start'      => $startLocal->format('Y-m-d H:i:s'), 
                'end'        => $endLocal->format('Y-m-d H:i:s'),
                'within_09_17' => $isWithinWorkingHours,
            ];
        }
    }

    return $output;
}



    static function getMyUpcoming(){
        $response = [];
        $myAppointment = self::getMyAppointment();
        if(!empty($myAppointment)){
            foreach($myAppointment as $appointment){
                if($appointment['status'] == 'On schedulled' ){
                    $response[] = [
                        'uuid'  => $appointment['uuid'],
                        'title' => $appointment['title'],
                        'creator' => $appointment['creator'],
                        'status'  => $appointment['status']
                    ];
                }
            }
        }

        return $response;
    }
    
   static function createAppointment($param)
{
    DB::beginTransaction();

    try {
        //Get waktu user location
        $timezone = null;
        $timezoneUsers = User::where('uuid',auth('api')->user()->uuid)
            ->select('preffered_timezone AS timezone')
            ->first();

        if(!empty($timezoneUsers)){
            $timezone = $timezoneUsers->timezone;
        }

        date_default_timezone_set($timezone);

        $convertUtc = validate_timezone($param);
        if($convertUtc['status'] == false ){
            return response()->json([
                'status' => 400,
                'message' => $convertUtc['message']
            ]);
        }

        $uuid = Uuid::uuid4()->toString();
        $invitesUser = $param->invites;

        $exec = Appointment::create([
            'uuid' => $uuid,
            'title' => $param->title,
            'start' => $param->start,
            'end' => $param->end,
            'creator_id' => auth('api')->user()->uuid,
            'timezone_location' => $timezone
        ]);

        if (!empty($invitesUser)) {
            foreach ($invitesUser as $user) {

                $checkUsers = DB::table('detail_appointment')
                    ->select('invite_to')
                    ->where('invite_to',$user)
                    ->join('appointment','appointment.uuid','=','detail_appointment.appointment_id')
                    ->whereBetween('appointment.start',[$param->start,$param->end])
                    ->whereBetween('appointment.end',[$param->start,$param->end])
                    ->first();

                if(!empty($checkUsers)){
                    $detailUser = User::where('uuid',$checkUsers->invite_to)->select('name')->first();
                    return response()->json([
                        'status' => 400,
                        'message' => 'User ' . $detailUser->name . ' sudah memiliki appointment dalam range waktu tersebut, silahkan pilih jam lain'
                    ]);
                }


                DB::table('detail_appointment')->insert([
                    'uuid' => Uuid::uuid4()->toString(), // generate UUID baru per row
                    'appointment_id' => $uuid,
                    'invite_to' => $user
                ]);
            }
        }

        DB::commit();

        return response()->json([
            'status' => 200,
            'message' => 'Create appointment success'
        ]);

    } catch (\Exception $ec) {
        DB::rollBack();

        return response()->json([
            'status' => 500,
            'message' => 'Internal server error',
            'error' => $ec->getMessage()
        ]);
    }
}



    

}