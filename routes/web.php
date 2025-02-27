<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\DashboardController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\PermissionController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/register/user', [RegisterController::class, 'register'])->name('register.user');



Route::group(['middleware' => ['auth', 'permission:access admin panel']], function () {

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('users', UserController::class);
Route::resource('user-permissions', PermissionController::class);
Route::resource('user-roles', RoleController::class);

Route::get('category', [CategoryController::class, 'index'])->name('category.index');
Route::get('product', [ProductController::class, 'index'])->name('product.index');
Route::get('order', [OrderController::class, 'index'])->name('order.index');

});
