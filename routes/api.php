<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login_process', [LoginController::class, 'login']);
Route::post('/register_process',[ProfileController::class,'register']);

Route::middleware('auth:api')->group(function(){
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/check-token',[LoginController::class,'checkToken']); 

    Route::prefix('profile')->group(function(){
        Route::get('/list',[ProfileController::class,'list'])->name('list');
        Route::get('/get',[ProfileController::class,'get'])->name('get');
        Route::put('/edit',[ProfileController::class,'edit'])->name('edit');
        Route::get('/search',[ProfileController::class,'searchProfile'])->name('search');
    });

    Route::prefix('appointment')->group(function(){
        Route::post('/create',[AppointmentController::class,'create'])->name('create');
        Route::get('/my',[AppointmentController::class,'getMyAppointment'])->name('my');
        Route::get('/upcoming',[AppointmentController::class,'getMyUpcoming'])->name('upcoming');
        Route::get('/detail/{uuid}',[AppointmentController::class,'detailAppointment'])->name('detail');
    });

});

