<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

           
            return redirect()->route('dashboard');
        }

        return redirect()->back()->withErrors(['email' => 'Email ou mot de passe incorrect.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}