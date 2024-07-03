<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginDashboardController extends Controller
{
    public function login(Request $request)
    {
    
        return view('loginform.login');
    }
    
    public function AuthLogin(Request $request)
    {
        // Check if the user has agreed to data privacy terms
    
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
    
    public function logoutButton()
    {
        Auth::logout();
        return redirect(url(''));
    }
    
}

