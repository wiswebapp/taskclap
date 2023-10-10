<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminAuthenticatedSessionController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\ProviderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PromocodeController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WalletController;

Route::prefix(config('app.admin_path_name'))->name('admin.')->group(function () {

    Route::middleware(['guest:admin'])->group(function() {
        Route::get('login', [AdminAuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AdminAuthenticatedSessionController::class, 'store']);
    });

    Route::middleware(['auth:admin'])->group(function() {
        Route::get('', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
        Route::put('profile', [DashboardController::class, 'updateProfile'])->name('updateProfile');
        Route::resource('users', UserController::class);
        Route::resource('categorys', CategoryController::class);
        Route::resource('banners', BannerController::class);
        Route::resource('providers', ProviderController::class);
        Route::resource('products', ProductController::class);
        Route::resource('products.services', ServiceController::class);
        Route::resource('promocode', PromocodeController::class);
        Route::resource('faq', FaqController::class);
        Route::resource('pages', PagesController::class);
        Route::resource('promocode', PromocodeController::class);
        Route::get('orders', [OrderController::class, 'index'])->name('orders');
        Route::get('orders/{order}', [OrderController::class, 'orderDetail'])->name('orders.detail');
        Route::post('orders/{order}', [OrderController::class, 'updateOrderDetail']);
        Route::get('report/payment', [OrderController::class, 'paymentReport'])->name('report.payment');
        Route::get('report/wallet', [WalletController::class, 'index'])->name('report.wallet');
        Route::post('report/wallet', [WalletController::class, 'transaction']);
        Route::post('logout', [AdminAuthenticatedSessionController::class, 'destroy'])->name('logout');

        ///-----------------Ajax Request For Web-----------------\\\
        Route::get('fetch/category', [CategoryController::class, 'fetchCategory'])->name('fetchCategory');
        Route::get('fetch/subcategory', [CategoryController::class, 'fetchSubcategory'])->name('fetchSubCategory');
    });

});
?>
