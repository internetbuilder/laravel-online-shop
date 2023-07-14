<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;


Route::middleware(['middleware' => 'auth:admin'])->group(function () {

    Route::view('/', 'admin.dashboard.index')->name('dashboard');


    Route::controller(SettingController::class)->group(function() {

        Route::get('settings', 'index')->name('settings');
        Route::post('settings', 'update')->name('settings.update');

    });

    Route::resource('categories', CategoryController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('products', ProductController::class);

    Route::controller(OrderController::class)->group(function() {

        Route::get('orders', 'index')->name('orders.index');
        Route::get('orders/{order:order_number}', 'show')->name('orders.show');

    });

});

