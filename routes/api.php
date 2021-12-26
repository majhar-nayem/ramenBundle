<?php

use App\Http\Controllers\Admin\BundleController;
use App\Http\Controllers\User\BundleController as PublicBundleController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\User\LoginController as UserLoginController;
use App\Http\Controllers\User\PlaceOrderController;
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

Route::get('products', [UserProductController::class, 'index']);
Route::get('products/{id}', [UserProductController::class, 'show']);

Route::get('bundles', [PublicBundleController::class, 'index']);
Route::get('bundles/{id}', [PublicBundleController::class, 'show']);

Route::group(['middleware' => 'auth:user', 'prefix' => 'user'], function () {
    Route::get('profile', [ProfileController::class, 'index']);
    Route::post('update-profile', [ProfileController::class, 'updateProfile']);
    Route::apiResource('orders', PlaceOrderController::class);
});

Route::group(['middleware' => 'auth:admin', 'prefix' => 'admin'], function () {
//   Route::get('profile', [ProfileController::class, 'index']);
//   Route::post('update-profile',[ProfileController::class,'updateProfile']);
    Route::apiResource('products', ProductController::class);
    Route::delete('sub-image/{id}', [ProductController::class, 'subImageDelete']);
    Route::apiResource('bundles', BundleController::class);
    Route::get('remove-from-bundle/{id}', [BundleController::class, 'removeBundleProducts']);
});
