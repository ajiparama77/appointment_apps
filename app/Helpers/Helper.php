<?php

use App\Models\User;
use Carbon\Carbon;

if (!function_exists('validate_timezone')){

    function validate_timezone($param){
        $uuid_invites = $param->invites;
        $uuid_user   = [auth('api')->user()->uuid];
        $participantsUuid = array_merge($uuid_invites,$uuid_user);

        $creatorTz = auth('api')->user()->preffered_timezone;

        $startUtc = Carbon::createFromFormat('Y-m-d H:i',$param->start,$creatorTz)
            ->setTimezone('UTC');

        $endUtc = Carbon::createFromFormat('Y-m-d H:i',$param->end,$creatorTz)
            ->setTimezone('UTC');

        $nowUtc = Carbon::now('UTC');

        $allUsers = User::whereIn('uuid',$participantsUuid)->get();

        foreach($allUsers as $user){
            $tz = $user->preffered_timezone;

            $nowLocal = (clone $nowUtc)->setTimezone($tz);

            $startLocal = (clone $startUtc)->setTimezone($tz);
            $endLocal  = (clone $endUtc)->setTimezone($tz);

            if ($endLocal->lt($nowLocal)) {
                return [
                    'status' => false,
                    'message' => "Waktu sudah dilewati pada timezone {$tz} untuk user {$user->name}",
                ];
            }

            // $nowLocal = now()->setTimezone()

            $startHour = (int) $startLocal->format('H');
            $endHour   = (int) $endLocal->format('H');

            $isWithinWorkingHours = $startHour >= 9 && $endHour <= 17;

             if (!$isWithinWorkingHours) {
                return [
                    'status' => false,
                    'message' => "Waktu tersebut di luar jam kerja (09:00-17:00) untuk user {$user->name} ({$tz})."
                ];
            }
        }

        return [
            'status'    => true,
            'message'   => 'Waktu valid untuk digunakan'
        ];
     
    }
};




