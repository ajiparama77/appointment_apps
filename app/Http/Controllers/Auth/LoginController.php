<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

  
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm(){
        return view('auth.register');
    }
    
     public function register(Request $request){
        try{

           
          $exec = DB::table('users')
             ->insert([
                'username'  => $request->username,
                'name'      => $request->name,
            
                'created_at' => now()
            ]);

            if(!$exec){
                return redirect()->to('/register')->with('failed','Register Failed');
            }

            return redirect()->to('/login')->with('success','Login success');

        }catch(\Exception $ec){
            return $ec->getMessage();
        }
    }

    public function login(Request $request){
        try{

            $request->validate([
                'username' => 'required'
            ]);

            $users = User::where('username',$request->input('username'))->first();
          
            if(!empty($users->username)){
             
                $token = auth('api')->login($users);
             
                return response()->json([
                    'meta' => [
                        'status' => 200,
                        'message' => 'Login Success'
                    ],
                    'data' => [
                        'access_token' => $token,
                        'token_type' => 'bearer',
                        'expires_in' => JWTAuth::factory()->getTTL() * 60, // detik
                        'user'      => $users
                    ],
                   
                ]);
            }

            return response()->json([
                'meta' => [
                    'status'   => 401,
                    'message'  => 'Unauthorized (email/password salah)'
                ],
               
            ]);


        }catch(\Exception $ec){
            return response()->json([
                'status' => 500,
                'message' => 'Login Error'
            ]);
        }
    }

    public function logout(){
        auth('api')->logout(); // invalidate token

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }

    public function checkToken(){
        return response()->json([
            'valid' => true
        ]);
    }


}
