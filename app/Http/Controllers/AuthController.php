<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /* User Login Form */
    public function loginForm()
    {
        return view('auth.login');
    }

    /* User Registration Form */
    public function registrationForm()
    {
        return view('auth.register');
    }

    /* User Forgot Password Form */
    public function forgotPasswordForm()
    {
        return view('auth.forgotPassword');
    }

    /* User Change Password Form */
    public function changePasswordForm()
    {
        return view('auth.changePassword');
    }

    /* User Logout */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('loginForm');
    }
}
