<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // Vérification que l'utilisateur a un des rôles autorisés
        if (!($user->hasRole(['admin', 'magasinier_technique', 'magasinier_collation']))) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }

        // Récupération des utilisateurs selon le rôle
        if ($user->hasRole('admin')) {
            $users = User::all();
        } elseif ($user->hasRole('magasinier_technique')) {
            $users = User::where('magasin_affecte', 'technique')->get();
        } elseif ($user->hasRole('magasinier_collation')) {
            $users = User::where('magasin_affecte', 'collation')->get();
        } else {
            // Sécurité supplémentaire
            $users = collect();
        }

        return view('users.index', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $user = auth()->user();

        // Seul admin peut créer un utilisateur
        if (!$user->hasRole('admin')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à créer un utilisateur.');
        }
        $users=User::all();
        return view('users.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $user = auth()->user();

        // Seul admin peut enregistrer un utilisateur
        if (!$user->hasRole('admin')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à créer un utilisateur.');
        }
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => ['required', 'regex:/^(70|71|72|73|74|75|76|77|78|79|90|91|92|93|94|95|96|97|98|99)[0-9]{6}$/'],
            'magasin_affecte' => 'required|in:collation,technique',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            $user = new User();

            // Transformer nom en majuscules
            $user->nom = mb_strtoupper($request->input('nom'));

            // Prénom et adresse : Première lettre en majuscule, le reste en minuscules
            $user->prenom = ucfirst(mb_strtolower($request->input('prenom')));
            $user->adresse = ucfirst(mb_strtolower($request->input('adresse')));

            // Téléphone inchangé
            $user->telephone = $request->input('telephone');

            $user->magasin_affecte = $request->input('magasin_affecte');


            // Email en minuscules
            $user->email = mb_strtolower($request->input('email'));

            // Password hashé
            $user->password = Hash::make($request->input('password'));

            $user->save();

            // 🎯 Assigner automatiquement un rôle selon magasin_affecte
            
            if ($user->magasin_affecte === 'technique') {
                $user->assignRole('magasinier_technique');
            }elseif ($user->magasin_affecte === 'collation') {
                $user->assignRole('magasinier_collation');
            }else{
                $user->assignRole('admin');

            }

            return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erreur lors de la création : ' . $e->getMessage()]);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        $users = auth()->user();

        // Admin + magasinier_technique + magasinier_pharmacie peuvent voir les détails utilisateur
        if (!($users->hasRole(['admin', 'magasinier_technique', 'magasinier_collation']))) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }

        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {

        $users = auth()->user();

        // Seul admin peut modifier un utilisateur
        if (!$users->hasRole('admin')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à modifier un utilisateur.');
        }
        return view('users.edit', compact('user'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $users = auth()->user();

        // Seul admin peut mettre à jour un utilisateur
        if (!$users->hasRole('admin')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à modifier un utilisateur.');
        }
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => ['required', 'regex:/^(70|71|72|73|74|75|76|77|78|79|90|91|92|93|94|95|96|97|98|99)[0-9]{6}$/'],
            'magasin_affecte' => 'required|in:collation,technique,admin',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->user_id . ',user_id',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        try {
            $user->nom = $request->input('nom');
            $user->prenom = $request->input('prenom');
            $user->adresse = $request->input('adresse');
            $user->telephone = $request->input('telephone');
            $user->magasin_affecte = $request->input('magasin_affecte');
            $user->email = $request->input('email');

            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }

            $user->save();

            return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erreur lors de la mise à jour : ' . $e->getMessage()]);
        }
    }


            
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $currentUser = auth()->user();

        if (!$currentUser->hasRole('admin')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à supprimer un utilisateur.');
        }

        if (
            $user->produits()->exists() ||
            $user->articles()->exists() 
            // $user->mouvements()->exists() ||
            // $user->mouvementsarticles()->exists()
        )
        {
            return back()->with('error', 'Impossible de supprimer cet utilisateur : des données lui sont encore liées.');
        }

        if ($user->user_id === $currentUser->user_id) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas vous supprimer vous-même.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Employé(é) supprimé avec succès !');
    }


}
