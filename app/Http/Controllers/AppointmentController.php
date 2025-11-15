<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AppointmentController extends Controller{

    public function index(){
        return view('appointment.index');
    }


    public function add(){
        return view('appointment.add');
    }

    public function create(Request $request){
        try{

            $rules = [
                'title'     => 'required|string',
                'start'     => 'required|date_format:Y-m-d H:i',
                'end'       => 'required|date_format:Y-m-d H:i',
                'invites'   => 'required|array'
            ];

            $messagesCustom = [
                'title.required' => 'Judul harus diisi',
                'start.required' => 'Waktu mulai harus diisi',
                'end.required'  => 'Wwaktu selesai harus diisi',
                'invites.required' => 'User harus dipilih'
            ];

            $validator = Validator::make($request->all(),$rules,$messagesCustom);
            if($validator->fails()){
                return response()->json([
                    'status' => 422,
                    'message' => 'Validasi gagal ' . $validator->errors()->first(),

                ]);
            }

            $exec = Appointment::createAppointment($request);
           
            return $exec;

        }catch(Exception $ec){
            return response()->json([
                'status' => 500,
                'message' => 'Internal server error ' . $ec->getMessage()
            ]);
        }
    }

  

    public function getMyAppointment(){
        try{

            $res = Appointment::getMyAppointment();
            if(!empty($res)){
                return response()->json([
                    'status' => 200,
                    'data'   => $res
                ]);
            };

            return response()->json([
                'status' => 400,
                'data'   => []
            ]);

        }catch(Exception $ec){
            return response()->json([
                'status' => 500,
                'message' => 'Internal server error ' . $ec->getMessage()
            ]);
        }
    }

    public function getMyUpcoming(){
        try{

            $res = Appointment::getMyUpcoming();
            if(!empty($res)){
                return response()->json([
                    'status' => 200,
                    'data' => $res
                ]);
            }

            return response()->json([
                'status' => 400,
                'data'   => []
            ]);

        }catch(Exception $ec){
            return response()->json([
                'status' => 500,
                'message' => 'Internal server error ' . $ec->getMessage()
            ]);
        }
    }

    public function detailAppointment($uuid){
        try{

            $response = Appointment::detailAppointments($uuid);
            if(!empty($response)){
                return response()->json([
                    'status' => 200,
                    'data'   => $response
                ]);
            }

            return response()->json([
                'status' => 400,
                'data'   => []
            ]);

        }catch(Exception $ec){
            return response()->json([
                'status' => 500,
                'message' => 'Internal server error ' . $ec->getMessage()
            ]);
        }
    }

}