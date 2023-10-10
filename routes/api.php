<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BaseApiController;
use App\Http\Controllers\API\v1\AuthController;
use App\Http\Controllers\API\v1\HomeApiController;
use App\Http\Controllers\API\v1\UserApiController;
use App\Http\Controllers\API\v1\WalletApiController;
use App\Http\Controllers\Api\v1\CategoryApiController;

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
Route::prefix(config('app.api_version'))->name('api.v1.')->group( function () {
    Route::post('signin', [AuthController::class, 'signin'])->name('signin');
    Route::post('signup', [AuthController::class, 'signup'])->name('signup');
    Route::get('getHomeData', [HomeApiController::class, 'getHomeData'])->name('getHomeData');
    Route::get('getSubCategory/{category}', [CategoryApiController::class, 'getSubCategory'])->name('getSubCategory');
    Route::get('faq', [BaseApiController::class, 'getFaq'])->name('faq');
    Route::middleware(['customApiAuthenticate'])->group( function () {
        Route::get('profile', [UserApiController::class, 'profile'])->name('profile');
        Route::post('profile', [UserApiController::class, 'updateProfile']);
        Route::get('wallet', [WalletApiController::class, 'getWalletTransactions']);
        Route::post('signout', [AuthController::class, 'signout'])->name('signout');
    });
});
