<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nom_pseudo' => 'required|string',
            'password' => 'required|string',
        ]);

        $pseudo = strtolower($request->input('nom_pseudo'));
        $password = $request->input('password');

        // Rechercher l'utilisateur par pseudo, sans tenir compte de la casse
        $user = User::whereRaw('LOWER(nom_pseudo) = ?', [$pseudo])->first();

        if ($user) {
            // 🔑 VÉRIFICATION CRITIQUE : Bloquer si désactivé
            if (!$user->is_active) {
                return redirect()->back()->with('error', 'Votre compte a été désactivé. Veuillez contacter l\'administrateur du CRTS.');
            }

            // Vérifie que les champs nom et prénom sont remplis
            if (!empty($user->nom) && !empty($user->prenom)) {
                // Vérifie le mot de passe hashé
                if (Hash::check($password, $user->password)) {
                    Auth::login($user);
                    
                    session()->flash('success', 'Connexion réussie. Bienvenue, ' . $user->nom .' ' .$user->prenom . '!');

                    // Redirection selon rôle
                    if ($user->hasRole('admin')) {
                        return redirect()->route('dashboard');
                    } elseif ($user->hasRole('magasinier_technique')) {
                        return redirect()->route('dashboard');
                    } elseif ($user->hasRole('magasinier_collation')) {
                        return redirect()->route('dashboard');
                    }

                    return redirect()->route('dashboard');
                }
            }
        }

        return redirect()->back()->with('error', 'Pseudo ou mot de passe incorrect.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Déconnexion réussie.');
    }
}