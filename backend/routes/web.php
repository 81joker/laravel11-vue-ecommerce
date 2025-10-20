<?php

use App\Models\Coupon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ColoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ProductController;

Route::get('/',[AdminController::class,'login'])->name('admin.login');
Route::post('admin/auth',[AdminController::class,'auth'])->name('admin.auth');

Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('dashboard',[AdminController::class,'index'])->name('admin.index');
    Route::post('logout',[AdminController::class,'logout'])->name('admin.logout');




// Categories
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class ,
    [
        'names' => [
            'index' => 'admin.categories.index',
            'create' => 'admin.categories.create',
            'store' => 'admin.categories.store',
            'edit' => 'admin.categories.edit',
            'update' => 'admin.categories.update',
            'destroy' => 'admin.categories.destroy',
        ]   
    ]);
// Brands
    Route::resource('brands', \App\Http\Controllers\Admin\BrandController::class ,
    [
        'names' => [
            'index' => 'admin.brands.index',
            'create' => 'admin.brands.create',
            'store' => 'admin.brands.store',
            'edit' => 'admin.brands.edit',
            'update' => 'admin.brands.update',
            'destroy' => 'admin.brands.destroy',
        ]   
    ]);
// Colors
    Route::resource('colors', ColoryController::class ,
    [
        'names' => [
            'index' => 'admin.colors.index',
            'create' => 'admin.colors.create',
            'store' => 'admin.colors.store',
            'edit' => 'admin.colors.edit',
            'update' => 'admin.colors.update',
            'destroy' => 'admin.colors.destroy',
        ]   
    ]);

// Size
    Route::resource('sizes', SizeController::class ,
    [
        'names' => [
            'index' => 'admin.sizes.index',
            'create' => 'admin.sizes.create',
            'store' => 'admin.sizes.store',
            'edit' => 'admin.sizes.edit',
            'update' => 'admin.sizes.update',
            'destroy' => 'admin.sizes.destroy',
        ]   
    ]);

    //products routes
    Route::resource("products",ProductController::class,[
        'names' => [
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy',
        ]
    ]);

    //coupons routes
    Route::resource("coupons",CouponController::class,[
        'names' => [
            'index' => 'admin.coupons.index',
            'create' => 'admin.coupons.create',
            'store' => 'admin.coupons.store',
            'edit' => 'admin.coupons.edit',
            'update' => 'admin.coupons.update',
            'destroy' => 'admin.coupons.destroy',
        ]
    ]);
});