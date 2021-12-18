<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\User\LoginController as UserLoginController;
use App\Http\Controllers\User\ProfileController;
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

Route::post('user/register', [UserLoginController::class, 'register']);
Route::post('user/login', [UserLoginController::class, 'login']);

Route::post('admin/login', [LoginController::class, 'emailLogin']);
Route::post('admin/verify', [LoginController::class, 'verifyOTP']);

Route::group(['middleware' => 'auth:user', 'prefix' => 'user'], function () {
   Route::get('profile', [ProfileController::class, 'index']);
   Route::post('update-profile',[ProfileController::class,'updateProfile']);
});
