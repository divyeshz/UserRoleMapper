<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Authentication Routes Group
Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'loginForm')->name('loginForm');
    Route::get('registration', 'registrationForm')->name('registrationForm');
    Route::get('forgotPassword', 'forgotPasswordForm')->name('forgotPasswordForm');
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
    Route::post('forgotPassword', 'forgotPassword')->name('forgotPassword');
    Route::get('resetPassword/{token}', 'resetPasswordForm')->name('resetPasswordForm');
    Route::post('resetPassword', 'resetPassword')->name('resetPassword');

    Route::get('logout', 'logout')->name('logout');
    Route::get('changePassword', 'changePasswordForm')->name('changePasswordForm');
    Route::post('changePassword', 'changePassword')->name('changePassword');
});

// User Routes Group
Route::controller(UserController::class)->group(function () {
    Route::get('profile', 'profile')->name('profile');

    Route::prefix('user')->group(function () {
        Route::get('list', 'index')->name('user.list');
        Route::get('create', 'create')->name('user.addForm');
        Route::post('store', 'store')->name('user.store');
        Route::get('edit/{id?}', 'edit')->name('user.editForm');
        Route::post('update/{id?}', 'update')->name('user.update');
        Route::post('destroy/{id?}', 'destroy')->name('user.destroy');
    });
});

// Role Routes Group
Route::controller(RoleController::class)->prefix('role')->group(function () {
    Route::get('List', 'list')->name('role.list');
    Route::get('AddForm', 'addForm')->name('role.addForm');
    Route::get('EditForm', 'editForm')->name('role.editForm');
});


// Permission Routes Group
Route::controller(PermissionController::class)->prefix('permission')->group(function () {
    Route::get('list', 'list')->name('permission.list');
    Route::get('AddForm', 'addForm')->name('permission.addForm');
    Route::get('edit', 'editForm')->name('permission.editForm');
});

// Module Routes Group
Route::controller(ModuleController::class)->prefix('module')->group(function () {
    Route::get('list', 'index')->name('module.list');
    Route::get('create', 'create')->name('module.addForm');
    Route::post('store', 'store')->name('module.store');
    Route::get('edit/{id?}', 'edit')->name('module.editForm');
    Route::post('update/{id?}', 'update')->name('module.update');
    Route::post('destroy/{id?}', 'destroy')->name('module.destroy');
    Route::post('status', 'status')->name('module.status');
});



Route::get('dashboard', function () {
    return view('pages.dashboard');
})->name('dashboard');
Route::group(['middleware' => 'auth'], function () {
});
