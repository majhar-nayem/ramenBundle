<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\User\LoginController as UserLoginController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
