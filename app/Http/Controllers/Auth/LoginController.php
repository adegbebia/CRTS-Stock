<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role; // Si vous utilisez des rôles ici
// use Spatie\Permission\Traits\HasRoles;




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

                session()->flash('success', 'Connexion réussie. Bienvenue, ' . $user->nom . ' !');


                
                if ($user->hasRole('admin')) {
                    return redirect()->route('dashboard'); // Redirection pour l'administrateur
                } elseif ($user->hasRole('magasinier_technique')) {
                    return redirect()->route('dashboard'); // Redirection pour le magasinier technique
                } elseif ($user->hasRole('magasinier_collation')) {
                    return redirect()->route('dashboard'); // Redirection pour le magasinier de collation
                }

            
                return redirect()->route('dashboard');
            }

            return redirect()->back()->with('error', 'Email ou mot de passe incorrect.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Déconnexion réussie.');

    }
}