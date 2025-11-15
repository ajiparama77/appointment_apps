<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dokumen\ReminderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/login',[LoginController::class,'showLoginForm'])->name('login');
Route::get('/register',[LoginController::class,'showRegisterForm'])->name('register');
Route::get('/',[HomeController::class,'index'])->name('dashboard');
Route::get('/profile',[ProfileController::class,'edit_view'])->name('profile');
Route::get('/users',[ProfileController::class,'show'])->name('show-users');
Route::get('/appointment',[AppointmentController::class,'index'])->name('appointment');
Route::get('/add-appointment',[AppointmentController::class,'add'])->name('add-appointment');