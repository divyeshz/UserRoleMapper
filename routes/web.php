<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
    Route::get('userList', 'list')->name('user.list');
    Route::get('userAddForm', 'addForm')->name('user.addForm');
    Route::get('userEditForm', 'editForm')->name('user.editForm');


});

// Role Routes Group
Route::controller(RoleController::class)->group(function () {
    Route::get('roleList', 'list')->name('role.list');
    Route::get('roleAddForm', 'addForm')->name('role.addForm');
    Route::get('roleEditForm', 'editForm')->name('role.editForm');

});


// Permission Routes Group
Route::controller(PermissionController::class)->group(function () {
    Route::get('permissionList', 'list')->name('permission.list');
    Route::get('permissionAddForm', 'addForm')->name('permission.addForm');
    Route::get('permissionEditForm', 'editForm')->name('permission.editForm');

});



Route::get('dashboard', function () {
    return view('pages.dashboard');
})->name('dashboard');
Route::group(['middleware' => 'auth'], function () {
});
