<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\AlertFormatter;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            "username" => "required",
            "password"  => "required"
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('dashboard');
        }
        return redirect()->back()->with(AlertFormatter::danger('Username atau password salah!'));

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
