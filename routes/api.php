<?php

use App\Http\Controllers\Admin\BundleController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\User\BundleController as PublicBundleController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\User\LoginController as UserLoginController;
use App\Http\Controllers\User\PlaceOrderController;
use App\Http\Controllers\User\ProfileController;
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

Route::get('paypal/response', [PaymentController::class, 'response']);

Route::group(['middleware' => 'auth:user', 'prefix' => 'user'], function () {
    Route::get('profile', [ProfileController::class, 'index']);
    Route::post('update-profile', [ProfileController::class, 'updateProfile']);
    Route::apiResource('orders', PlaceOrderController::class);

    Route::post('pay', [PaymentController::class, 'pay']);
});

Route::group(['middleware' => 'auth:admin', 'prefix' => 'admin'], function () {
//   Route::get('profile', [ProfileController::class, 'index']);
//   Route::post('update-profile',[ProfileController::class,'updateProfile']);
    Route::apiResource('products', ProductController::class);
    Route::delete('sub-image/{id}', [ProductController::class, 'subImageDelete']);
    Route::apiResource('bundles', BundleController::class);
    Route::post('add-product-to-bundle', [BundleController::class, 'addToBundle']);
    Route::delete('remove-from-bundle/{id}', [BundleController::class, 'removeBundleProducts']);
    Route::apiResource('coupons', CouponController::class);

    Route::apiResource('orders', OrderController::class);
    Route::apiResource('customers', CustomerController::class);
    Route::get('stats', [StatsController::class, 'index']);
});
