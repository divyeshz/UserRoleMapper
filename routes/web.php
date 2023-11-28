<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DemoController;
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
            Route::post('status', 'status')->name('user.status')->middleware('access.control:user,edit');
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
        Route::post('status', 'status')->name('role.status')->middleware('access.control:role,edit');
    });

    // Permission Routes Group
    Route::controller(PermissionController::class)->prefix('perm')->group(function () {
        Route::get('list', 'index')->name('perm.list')->middleware('access.control:perm,view');
        Route::get('create', 'create')->name('perm.addForm')->middleware('access.control:perm,add');
        Route::post('store', 'store')->name('perm.store')->middleware('access.control:perm,add');
        Route::get('show/{id}', 'show')->name('perm.show')->middleware('access.control:perm,view');
        Route::get('edit/{id}', 'edit')->name('perm.editForm')->middleware('access.control:perm,edit');
        Route::post('update/{id}', 'update')->name('perm.update')->middleware('access.control:perm,edit');
        Route::post('destroy/{id}', 'destroy')->name('perm.destroy')->middleware('access.control:perm,delete');
        Route::post('delete/{id}', 'delete')->name('perm.delete')->middleware('access.control:perm,delete');
        Route::get('restore/{id}', 'restore')->name('perm.restore')->middleware('access.control:perm,restore');
        Route::post('status', 'status')->name('perm.status')->middleware('access.control:perm,edit');
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
        Route::post('status', 'status')->name('module.status')->middleware('access.control:module,edit');
    });

    // Demo Routes Group
    Route::controller(DemoController::class)->prefix('demo')->group(function () {
        Route::get('list', 'index')->name('demo.list')->middleware('access.control:demo,view');
        Route::get('create', 'create')->name('demo.addForm')->middleware('access.control:demo,add');
        Route::post('store', 'store')->name('demo.store')->middleware('access.control:demo,add');
        Route::get('show/{id}', 'show')->name('demo.show')->middleware('access.control:demo,view');
        Route::get('edit/{id}', 'edit')->name('demo.editForm')->middleware('access.control:demo,edit');
        Route::post('update/{id}', 'update')->name('demo.update')->middleware('access.control:demo,edit');
        Route::post('destroy/{id}', 'destroy')->name('demo.destroy')->middleware('access.control:demo,delete');
        Route::post('delete/{id}', 'delete')->name('demo.delete')->middleware('access.control:demo,delete');
        Route::get('restore/{id}', 'restore')->name('demo.restore')->middleware('access.control:demo,restore');
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
