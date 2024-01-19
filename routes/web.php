<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [HomeController::class ,'FrontendHome']);

Route::post('/user-registration', [UserController::class ,'UserRegistration']);
Route::post('/user-login', [UserController::class ,'UserLogin']);
Route::post('/send-otp', [UserController::class ,'SendOtp']);
Route::post('/veryfy-otp', [UserController::class ,'VerifyOTP']);

// middleware check verify otp than reset passeord
Route::post('/reset-password', [UserController::class ,'ResetPassword'])->middleware('verifyJWTToken');