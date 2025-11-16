<?php

namespace App\Models;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Profile extends Model{

    static function Register($param){

            //Cek apakah username sudah pernah register
            $cekUsers = User::where('username',$param->username)->exists();
            if($cekUsers){
                return response()->json([
                    'status' => 400,
                    'message' => 'User sudah terdaftar'
                ]);
            }
            date_default_timezone_set($param->preffered);
            $uuid =  Uuid::uuid4()->toString();
            $users = User::create([
                'uuid'              => $uuid,
                'username'           => $param->username,
                'name'               => $param->name,
                'preffered_timezone' => $param->preffered
            ]);

            if($users){
                return response()->json([
                    'status' => 200,
                    'message' => 'OK'
                ]);
            }

            return response()->json([
                'status' => 400,
                'message' => 'Bad Request'
            ]);


    }

  

    static function getProfile()
    {


        $users = User::where('uuid', auth('api')->user()->uuid)
            ->select('username', 'name', 'preffered_timezone')
            ->first();

        if (!empty($users)) {
            return response()->json([
                'status' => 200,
                'message' => 'Data fetched',
                'data' => $users
            ]);
        }

        return response()->json([
            'status' => 400,
            'message' => 'Data empty',
            'data' => $users
        ]);


    }

    static function EditProfile($param){
       

            $users = User::where('uuid',auth('api')->user()->uuid)
            ->update([
                'username'           => $param->username,
                'name'               => $param->name,
                'preffered_timezone' => $param->preffered
            ]);

            if($users){
                return response()->json([
                    'status'    => 200,
                    'message'   => 'OK'
                ]);
            }

            return response()->json([
                'status' => 400,
                'message' => 'Bad Request'
            ]);
        
    }


    static function listProfile(){
       $users = User::select('username','name','preffered_timezone')
            ->get();

        if($users->isNotEmpty()){
            $users->toArray();
            return response()->json([
                'status' => 200,
                'message' => 'Data fetched',
                'data'    => $users
            ]);
        }

          return response()->json([
                'status' => 400,
                'message' => 'Data empty'
            ]);

    }


    static function searchProfile($param){
        $userSelected = $param->usersSelected;

        $profileLoggedin = User::select('uuid')
        ->where('username',auth('api')->user()->username )
        ->pluck('uuid')
        ->toArray();

        $users = User::select('uuid','username','name')
            ->whereNotIn('uuid',$profileLoggedin)
            ->where('username','ILIKE','%' . $param->username .'%')
            ;


        if(!empty($userSelected)){
            $users->whereNotIn('uuid',$userSelected);
        }

        $users = $users->get();

        if($users->isNotEmpty()){
            $users->toArray();
            return response()->json([
                'status' => 200,
                'message' => 'Data fetched',
                'data'    => $users
            ]);
        }
        
        return response()->json([
            'status' => 400,
            'message' => 'Data empty',
            'data'    => []
        ]);

    }
}