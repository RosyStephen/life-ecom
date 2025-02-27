<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\API\Master\CategoryController;
use App\Http\Controllers\API\Orders\OrderController;
use App\Http\Controllers\API\Products\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::prefix('master')->group(function () {
    Route::apiResource('categories', CategoryController::class);
    Route::get('category/trashed', [CategoryController::class, 'trashed'])->name('master.category.trashed');
    Route::put('category/restore/{category}', [CategoryController::class, 'restore'])->name('master.category.restore');
    Route::delete('category/force-delete/{category}', [CategoryController::class, 'forceDelete'])->name('master.category.force.dlete');
});


Route::prefix('products')->group(function () {
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::post('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('product/delete-image/{image}', [ProductController::class, 'deleteImage'])->name('products.product.delete-image');
    Route::get('product/trashed', [ProductController::class, 'trashed'])->name('products.product.trashed');
    Route::put('product/restore/{product}', [ProductController::class, 'restore'])->name('products.product.restore');
    Route::delete('product/force-delete/{product}', [ProductController::class, 'forceDelete'])->name('products.product.force.dlete');
});

Route::prefix('orders')->group(function () {
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('order', [OrderController::class, 'createOrder'])->name('orders.store');
    Route::get('order/{code}', [OrderController::class, 'show'])->name('orders.show');

});

Route::prefix('auth')->group(function () {
    Route::post('login', [LoginController::class, 'login'])->name('auth.login');
    Route::post('logout', [LoginController::class, 'logout'])->name('auth.logout');
    Route::post('register', [RegisterController::class, 'register'])->name('auth.register');
    Route::post('verify-email', [RegisterController::class, 'verifyEmail'])->name('auth.verify-email');
    Route::post('resend-otp', [RegisterController::class, 'resendOTP'])->name('auth.resend-otp');
});
