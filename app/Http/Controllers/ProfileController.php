<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Http\Request;

class ProfileController extends Controller{
    public function edit_view(){
        return view('profile.edit-profile');
    }

    public function show(){
        return view('profile.index');
    }

    public function list(){
        try{

            $users = Profile::listProfile();
            return $users;

        }catch(Exception $ec){
            return response()->json([
                'status' => 500,
                'message' => 'Error ' . $ec->getMessage()
            ]);
        }
    }

    public function get(){
        try{

            $exec = Profile::getProfile();
            return $exec;

        }catch(Exception $ec){
            return response()->json([
                'status' => 500,
                'message' => 'Error ' . $ec->getMessage()
            ]);
        }
    }

    public function register(Request $request){
        try{

            $rules = [
                'username' => 'required|string',
                'name' => 'required|string',
                'preffered' => 'required'
            ];

            $messages = [
                'username.required' => 'Username wajib diisi.',
                'username.string' => 'Username harus berupa teks.',
                'name.required' => 'Nama lengkap wajib diisi.',
                'name.string' => 'Nama harus berupa teks.',
                'preffered.required' => 'Preferred wajib dipilih.',
            ];

            $validate = Validator::make($request->all(), $rules, $messages);
            if ($validate->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Validasi gagal ' . $validate->errors()->first(),

                ]);
            }

            $exec = Profile::Register($request);
            return $exec;


        }catch(Exception $ec){
            return response()->json([
                'status' => 500,
                'message' => 'Error ' . $ec->getMessage()
            ]);
        }
    }


    public function edit(Request $request){
        try{

            $rules = [
                'username'       => 'required|string',
                'name'           => 'required|string',
                'preffered'      => 'required'
            ];

            $messages = [
                'username.required' => 'Username wajib diisi.',
                'username.string' => 'Username harus berupa teks.',
                'name.required' => 'Nama lengkap wajib diisi.',
                'name.string' => 'Nama harus berupa teks.',
                'preffered.required' => 'Preferred wajib dipilih.',
            ];


            $validate = Validator::make($request->all(), $rules, $messages);
            if ($validate->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Validasi gagal ' . $validate->errors(),
                    
                ]);
            }

            $exec = Profile::EditProfile($request);
            return $exec;

        }catch(Exception $ec){
            return response()->json([
                'status' => 500,
                'message' => 'Error ' . $ec->getMessage()
            ]);
        }
    }   

    public function searchProfile(Request $request){
        try{

            $exec = Profile::searchProfile($request);
            return $exec;

        }catch(Exception $ec){
            return response()->json([
                'status' => 500,
                'message' => 'Error ' . $ec->getMessage()
            ]);
        }
    }
    

}