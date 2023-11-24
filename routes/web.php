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
    Route::get('activate/{id}','activate')->name('activate.user');

    Route::group(['middleware' => ['auth', 'forceLogout']], function () {
        Route::post('logout', 'logout')->name('logout');
        Route::post('changePassword', 'changePassword')->name('changePassword');
        Route::get('changePassword', 'changePasswordForm')->name('changePasswordForm');
        Route::get('dashboard', 'dashboard')->name('dashboard');
    });
});

Route::group(['middleware' => ['auth', 'forceLogout']], function () {

    // User Routes Group
    Route::controller(UserController::class)->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('profile', 'profile')->name('profile');
            Route::get('list', 'index')->name('user.list')->middleware('access.control:user,view');
            Route::get('create', 'create')->name('user.addForm')->middleware('access.control:user,add');
            Route::post('store', 'store')->name('user.store')->middleware('access.control:user,add');
            Route::get('show/{id}', 'show')->name('user.show')->middleware('access.control:user,view');
            Route::get('edit/{id}', 'edit')->name('user.editForm')->middleware('access.control:user,edit');
            Route::post('update/{id}', 'update')->name('user.update')->middleware('access.control:user,edit');
            Route::post('destroy/{id}', 'destroy')->name('user.destroy')->middleware('access.control:user,delete');
            Route::post('delete/{id}', 'delete')->name('user.delete')->middleware('access.control:user,delete');
            Route::get('restore/{id}', 'restore')->name('user.restore')->middleware('access.control:user,restore');
            Route::post('status', 'status')->name('user.status')->middleware('access.control:user,status');
            Route::post('logout/{id}', 'forceLogout')->name('user.forceLogout')->middleware('access.control:user,forceLogout');
        });
    });

    // Role Routes Group
    Route::controller(RoleController::class)->prefix('role')->group(function () {
        Route::get('list', 'index')->name('role.list')->middleware('access.control:role,view');
        Route::get('create', 'create')->name('role.addForm')->middleware('access.control:role,add');
        Route::post('store', 'store')->name('role.store')->middleware('access.control:role,add');
        Route::get('show/{id}', 'show')->name('role.show')->middleware('access.control:role,view');
        Route::get('edit/{id}', 'edit')->name('role.editForm')->middleware('access.control:role,edit');
        Route::post('update/{id}', 'update')->name('role.update')->middleware('access.control:role,edit');
        Route::post('destroy/{id}', 'destroy')->name('role.destroy')->middleware('access.control:role,delete');
        Route::post('delete/{id}', 'delete')->name('role.delete')->middleware('access.control:role,delete');
        Route::get('restore/{id}', 'restore')->name('role.restore')->middleware('access.control:role,restore');
        Route::post('status', 'status')->name('role.status')->middleware('access.control:role,status');
    });

    // Permission Routes Group
    Route::controller(PermissionController::class)->prefix('permission')->group(function () {
        Route::get('list', 'index')->name('permission.list')->middleware('access.control:permission,view');
        Route::get('create', 'create')->name('permission.addForm')->middleware('access.control:permission,add');
        Route::post('store', 'store')->name('permission.store')->middleware('access.control:permission,add');
        Route::get('show/{id}', 'show')->name('permission.show')->middleware('access.control:permission,view');
        Route::get('edit/{id}', 'edit')->name('permission.editForm')->middleware('access.control:permission,edit');
        Route::post('update/{id}', 'update')->name('permission.update')->middleware('access.control:permission,edit');
        Route::post('destroy/{id}', 'destroy')->name('permission.destroy')->middleware('access.control:permission,delete');
        Route::post('delete/{id}', 'delete')->name('permission.delete')->middleware('access.control:permission,delete');
        Route::get('restore/{id}', 'restore')->name('permission.restore')->middleware('access.control:permission,restore');
        Route::post('status', 'status')->name('permission.status')->middleware('access.control:permission,status');
    });

    // Module Routes Group
    Route::controller(ModuleController::class)->prefix('module')->group(function () {
        Route::get('list', 'index')->name('module.list')->middleware('access.control:module,view');
        Route::get('create', 'create')->name('module.addForm')->middleware('access.control:module,add');
        Route::post('store', 'store')->name('module.store')->middleware('access.control:module,add');
        Route::get('show/{id}', 'show')->name('module.show')->middleware('access.control:module,view');
        Route::get('edit/{id}', 'edit')->name('module.editForm')->middleware('access.control:module,edit');
        Route::post('update/{id}', 'update')->name('module.update')->middleware('access.control:module,edit');
        Route::post('destroy/{id}', 'destroy')->name('module.destroy')->middleware('access.control:module,delete');
        Route::post('delete/{id}', 'delete')->name('module.delete')->middleware('access.control:module,delete');
        Route::get('restore/{id}', 'restore')->name('module.restore')->middleware('access.control:module,restore');
        Route::post('status', 'status')->name('module.status')->middleware('access.control:module,status');
    });

    // forbidden Route
    Route::get('forbidden', function () {
        return view('pages.forbidden');
    })->name('forbidden');

    // coming soon Route
    Route::get('comingSoon', function () {
        return view('pages.comingSoon');
    })->name('comingSoon');

});
