<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

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


});