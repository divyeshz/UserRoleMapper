<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\ForgotPasswordMail;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /* User Login Form */
    public function loginForm()
    {
        return view('auth.login');
    }

    /*  User Login */
    public function login(Request $request)
    {
        // Validate Data
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required|min:6',
        ]);

        // Attempt for Login With User Credentials
        $credential = $request->only('email', 'password');

        $user = User::where('email', $credential['email'])->first();
        if ($user && Hash::check($credential['password'], $user->password)) {
            if ($user->is_active != 1 && $user->deleted_at == null && $user->is_deleted == 0) {
                return redirect()->route('loginForm')->with('error', 'Your Account Is Not Active!!!');
            }
            if (Auth::attempt($credential)) {
                if (Auth::user()->is_first_login == 1 && Auth::user()->is_active == 1 && Auth::user()->deleted_at == null &&  Auth::user()->is_deleted == 0) {
                    return redirect()->route('loginChangePasswordForm')->with('error', 'Change Your Password First!!!');
                }
                return redirect()->route('dashboard')->with('success', 'Login SuccessFully!!!');
            }
        }
        return redirect()->route('loginForm')->with('error', 'Invaild Credential!!!');
    }

    public function loginChangePasswordFrom()
    {
        return view('auth.loginChangePassword');
    }
    public function loginChangePassword(Request $request)
    {
        // Validate Data
        $request->validate([
            'new_password'          => 'required|min:6',
            'confirm_new_password'  => 'required|min:6|same:new_password',
        ]);

        $user = User::findorfail(Auth::id());
        $user->update([
            'is_first_login'    => 0,
            'password'          => Hash::make($request->new_password),
        ]);
        if($user){
            return redirect()->route('dashboard')->with('success', 'Login SuccessFully!!!');
        }else{
            return redirect()->route('loginChangePasswordForm')->with('erroe', 'Change Password Failed!!!');
        }
    }

    /* User Registration Form */
    public function registrationForm()
    {
        return view('auth.register');
    }

    /* Register New User Data Into Database */
    public function register(Request $request)
    {
        // Validate Data
        $request->validate([
            'fname'          => 'required|string',
            'lname'          => 'required|string',
            'email'          => 'required|email',
            'password'       => 'required|min:6',
        ]);

        // Store data Into User Table
        $user = User::create([
            'first_name'          => $request->fname,
            'last_name'          => $request->lname,
            'email'          => $request->email,
            'is_active'      => 0,
            'is_first_login' => 1,
            'type' => 'user',
            'password'       => Hash::make($request->password),
        ]);
        if($user){
            return redirect()->route('loginForm')->with('success', 'Register SuccessFully!!! Now Contact Admin To Active Account For Login.');
        }else{
            return redirect()->route('registrationForm')->with('success', 'Register Failed!!!');
        }

    }

    /* User Forgot Password Form */
    public function forgotPasswordForm()
    {
        return view('auth.forgotPassword');
    }

    /* Actual Functionality for Forgot Password */
    public function forgotPassword(Request $request)
    {
        // Validate Data
        $request->validate([
            'email' => 'required|email'
        ]);

        $valid = true;
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $valid = false;
            return redirect()->route('forgotPasswordForm')->with('error', 'Invaild Credential!!!');
        }

        $prt_data = PasswordResetToken::where('email', $request->email)->where('token','!=','')->first();
        if ($prt_data != null) {
            $valid = false;
            return redirect()->route('forgotPasswordForm')->with('error', 'Mail is already sent. check your email!!!');
        }

        if ($valid) {
            $token = Str::random(100);
            PasswordResetToken::insert([
                'email'         => $user->email,
                'token'         => $token,
                'created_at'    => now(),
            ]);

            dispatch(function () use ($user, $token) {
                Mail::to($user->email)->send(new ForgotPasswordMail($user, $token));
            });

            return redirect()->route('loginForm')->with('success', 'We have sent you a mail');
        }
    }

    // Show Reset Password Form
    public function resetPasswordForm($token)
    {
        $prt_data = PasswordResetToken::where('token', $token)->first();

        if (!$prt_data || Carbon::now()->subminutes(10) > $prt_data->created_at) {
            return redirect()->route('forgotPasswordForm')->with('error', 'Invalid password reset link or link is expired.');
        } else {
            return view('auth.resetPassword', compact('token'));
        }
    }

    /* Actual Functionality for Reset Password */
    public function resetPassword(Request $request)
    {
        $prt_data = PasswordResetToken::where('token', $request->prt_token)->first();
        $email = $prt_data->email;
        $user = User::where('email', $email)->first();

        if (!$prt_data || Carbon::now()->subminutes(10) > $prt_data->created_at) {
            return redirect()->back()->with('error', 'Invalid password reset link or link expired.');
        } else {

            // Validate Data
            $request->validate([
                'prt_token'         => 'required',
                'password'          => 'required|min:6',
                'confirm_password'  => 'required|min:6|same:password',
            ]);

            $user->update([
                'password' => Hash::make($request->password)
            ]);

            $prt_data = PasswordResetToken::where('token', $request->prt_token)->delete();

            return redirect()->route('loginForm')->with('success', 'Password Reset successfully!!!');
        }
    }

    /* User Change Password Form */
    public function changePasswordForm()
    {
        return view('auth.changePassword');
    }

    /* Actual Functionality for Change Password */
    public function changePassword(Request $request)
    {
        // Validate Data
        $request->validate([
            'old_password'          => 'required|min:6',
            'new_password'          => 'required|min:6',
            'confirm_new_password'  => 'required|min:6|same:new_password',
        ]);

        $user = User::where('email', Auth::user()->email)->first();

        if ($user && Hash::check($request->old_password, $user->password)) {
            $newPassword = Hash::make($request->new_password);
            $user->password = $newPassword;
            $user->save();

            return redirect()->route('changePasswordForm')->with('success', 'Password Change SuccessFully!!!');
        } else {
            return redirect()->route('changePasswordForm')->with('error', 'Invaild Credential!!!');
        }
    }

    /* User Logout */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('loginForm');
    }
}
