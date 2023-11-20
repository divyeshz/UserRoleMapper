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
    Route::post('forgotPassword', 'forgotPassword')->name('forgotPassword');
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
    Route::get('resetPassword/{token}', 'resetPasswordForm')->name('resetPasswordForm');
    Route::post('resetPassword', 'resetPassword')->name('resetPassword');
    Route::get('loginChangePassword', 'loginChangePasswordFrom')->name('loginChangePasswordForm');
    Route::post('loginChangePassword', 'loginChangePassword')->name('loginChangePassword');

    Route::group(['middleware' => ['auth','forceLogout']], function () {
        Route::post('logout', 'logout')->name('logout');
        Route::post('changePassword', 'changePassword')->name('changePassword');
        Route::get('changePassword', 'changePasswordForm')->name('changePasswordForm');
    });
});

Route::group(['middleware' => ['auth','forceLogout']], function () {

    // User Routes Group
    Route::controller(UserController::class)->group(function () {
        Route::get('profile', 'profile')->name('profile');

        Route::prefix('user')->group(function () {
            Route::get('list', 'index')->name('user.list');
            Route::get('create', 'create')->name('user.addForm');
            Route::post('store', 'store')->name('user.store');
            Route::get('show/{id}', 'show')->name('user.show');
            Route::get('edit/{id}', 'edit')->name('user.editForm');
            Route::post('update/{id}', 'update')->name('user.update');
            Route::post('destroy/{id}', 'destroy')->name('user.destroy');
            Route::post('delete/{id}', 'delete')->name('user.delete');
            Route::get('restore/{id}', 'restore')->name('user.restore');
            Route::post('status', 'status')->name('user.status');
            Route::post('logout/{id}', 'forceLogout')->name('user.forceLogout');
        });
    });

    // Role Routes Group
    Route::controller(RoleController::class)->prefix('role')->group(function () {
        Route::get('list', 'index')->name('role.list');
        Route::get('create', 'create')->name('role.addForm');
        Route::post('store', 'store')->name('role.store');
        Route::get('show/{id}', 'show')->name('role.show');
        Route::get('edit/{id}', 'edit')->name('role.editForm');
        Route::post('update/{id}', 'update')->name('role.update');
        Route::post('destroy/{id}', 'destroy')->name('role.destroy');
        Route::post('delete/{id}', 'delete')->name('role.delete');
        Route::get('restore/{id}', 'restore')->name('role.restore');
        Route::post('status', 'status')->name('role.status');
    });

    // Permission Routes Group
    Route::controller(PermissionController::class)->prefix('permission')->group(function () {
        Route::get('list', 'index')->name('permission.list');
        Route::get('create', 'create')->name('permission.addForm');
        Route::post('store', 'store')->name('permission.store');
        Route::get('show/{id}', 'show')->name('permission.show');
        Route::get('edit/{id}', 'edit')->name('permission.editForm');
        Route::post('update/{id}', 'update')->name('permission.update');
        Route::post('destroy/{id}', 'destroy')->name('permission.destroy');
        Route::post('delete/{id}', 'delete')->name('permission.delete');
        Route::get('restore/{id}', 'restore')->name('permission.restore');
        Route::post('status', 'status')->name('permission.status');
    });

    // Module Routes Group
    Route::controller(ModuleController::class)->prefix('module')->group(function () {
        Route::get('list', 'index')->name('module.list');
        Route::get('create', 'create')->name('module.addForm');
        Route::post('store', 'store')->name('module.store');
        Route::get('show/{id}', 'show')->name('module.show');
        Route::get('edit/{id}', 'edit')->name('module.editForm');
        Route::post('update/{id}', 'update')->name('module.update');
        Route::post('destroy/{id}', 'destroy')->name('module.destroy');
        Route::post('delete/{id}', 'delete')->name('module.delete');
        Route::get('restore/{id}', 'restore')->name('module.restore');
        Route::post('status', 'status')->name('module.status');
    });

    Route::get('dashboard', function () {
        return view('pages.dashboard');
    })->name('dashboard');
    Route::group(['middleware' => 'auth'], function () {
    });
});
