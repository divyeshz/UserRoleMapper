<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\ForgotPasswordMail;
use App\Mail\AccountActivatedMail;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\NewUserNotification;
use App\Traits\DispatchEmails;
use App\Traits\ControllerTrait;

class AuthController extends Controller
{
    use DispatchEmails, ControllerTrait;
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
            'password'  => 'required|min:6|string'
        ]);

        // Attempt for Login With User Credentials
        $credential = $request->only('email', 'password');

        $user = User::where('email', $credential['email'])->first();
        if ($user && Hash::check($credential['password'], $user->password)) {
            if ($user->is_active != true) {
                return redirect()->route('loginForm')->with('error', 'Your Account Is Not Active!!!');
            }
            if (Auth::attempt($credential)) {
                $user->createToken('AuthToken')->plainTextToken;
                if (Auth::user()->is_first_login == true) {
                    return redirect()->route('loginChangePasswordForm')->with('error', 'Change Your Password First!!!');
                }
                return redirect()->route('dashboard')->with('success', 'Login SuccessFully!!!');
            }
        }
        return redirect()->route('loginForm')->with('error', 'Invaild Credential!!!');
    }

    /*  first time login then Change Password From display */
    public function loginChangePasswordFrom()
    {
        return view('auth.loginChangePassword');
    }

    /*  first time login then Change Password function */
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
        if ($user) {
            return redirect()->route('dashboard')->with('success', 'Login SuccessFully!!!');
        } else {
            return redirect()->route('loginChangePasswordForm')->with('error', 'Change Password Failed!!!');
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
            'email'          => 'unique:users|required|email',
            'password'       => 'required|min:6|string',
        ]);

        // Store data Into User Table
        $user = User::create([
            'first_name'        => $request->fname,
            'last_name'         => $request->lname,
            'email'             => $request->email,
            'is_active'         => 0,
            'is_first_login'    => 1,
            'type'              => 'user',
            'password'          => Hash::make($request->password),
        ]);
        if ($user) {
            $adminUser = User::where('type', 'admin')->first();
            // Notify the admin about the new user
            $adminUser->notify(new NewUserNotification($user, $adminUser->email));

            return redirect()->route('loginForm')->with('success', 'Register SuccessFully!!! Now Contact Admin To Active Account For Login.');
        } else {
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

        $prt_data = PasswordResetToken::where('email', $request->email)->where('token', '!=', '')->first();
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

            // Call the sendEmail method from the trait
            $userEmail = $user->email; // $user holds the user data
            $mailData = new ForgotPasswordMail($user, $token); // $data holds the necessary data
            $this->sendEmail($userEmail, $mailData);

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
                'password'          => 'required|min:6|string',
                'confirm_password'  => 'required|min:6|same:password|string',
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
        $modules = $this->modules();
        $uniqueModules = $this->uniqueModules();
        return view('auth.changePassword', compact('modules', 'uniqueModules'));
    }

    /* Actual Functionality for Change Password */
    public function changePassword(Request $request)
    {
        // Validate Data
        $request->validate([
            'old_password'          => 'required|min:6|string',
            'new_password'          => 'required|min:6|string',
            'confirm_new_password'  => 'required|min:6|same:new_password|string',
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

    /* Activate the user */
    public function activate(string $id)
    {
        $user = User::findorfail($id);

        $user->update([
            'is_active' => 1,
        ]);

        if ($user) {
            // Call the sendEmail method from the trait
            $userEmail = $user->email; // $user holds the user data
            $mailData = new AccountActivatedMail($user); // $data holds the necessary data
            $this->sendEmail($userEmail, $mailData);
        }

        return redirect()->route('loginForm')->with('success', "$user->first_name $user->last_name Your account has been activated. Please login ");
    }

    /* User Logout */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('loginForm');
    }

    /* Dashboard */
    public function dashboard()
    {
        $modules = $this->modules();
        $uniqueModules = $this->uniqueModules();
        return view('pages.dashboard', compact('modules', 'uniqueModules'));
    }

    /* coming soon */
    public function comingSoon()
    {
        $modules = $this->modules();
        $uniqueModules = $this->uniqueModules();
        return view('pages.comingSoon', compact('modules', 'uniqueModules'));
    }

    /* forbidden Route */
    public function forbidden()
    {
        $modules = $this->modules();
        $uniqueModules = $this->uniqueModules();
        return view('pages.forbidden', compact('modules', 'uniqueModules'));
    }
}
