<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginDashboardController extends Controller
{
    public function login(Request $request)
    {
        return view('loginform.login');
    }

    public function forgetpassword(Request $request)
    {
        return view('loginform.forget');
    }

    public function AuthLogin(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, true)) {
            $viewPath = Auth::user()->user_type == 0
                ? 'SuperAdmin/Dashboard'
                : (Auth::user()->user_type == 1
                    ? 'Admin/Dashboard'
                    : 'Employee/Dashboard');

            return redirect($viewPath);
        } else {
            return redirect()->back()->with('error', 'Please input the correct email and password');
        }
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function logoutButton()
    {
        Auth::logout();
        return redirect(url(''));
    }
}
