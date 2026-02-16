<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; 

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!($user->hasRole(['admin', 'magasinier_technique', 'magasinier_collation']))) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }

        $search = $request->input('search');
        $paginates = 10;
        
        // ✅ CORRIGÉ : Aucun filtrage par statut - TOUS les utilisateurs sont affichés
        $query = User::query();

        // Récupération selon le rôle
        if ($user->hasRole('admin')) {
            // Admin voit TOUS les utilisateurs (actifs + désactivés)
        } elseif ($user->hasRole('magasinier_technique')) {
            $query->where('magasin_affecte', 'technique');
        } elseif ($user->hasRole('magasinier_collation')) {
            $query->where('magasin_affecte', 'collation');
        } else {
            $query->whereRaw('1 = 0');
        }

        // Appliquer le filtre de recherche
        if ($search) {
            $search = strtolower($search);

            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(nom) LIKE ?', ["%$search%"])
                ->orWhereRaw('LOWER(nom_pseudo) LIKE ?', ["%$search%"])
                ->orWhereRaw('LOWER(prenom) LIKE ?', ["%$search%"])
                ->orWhereRaw('LOWER(adresse) LIKE ?', ["%$search%"])
                ->orWhereRaw('LOWER(telephone) LIKE ?', ["%$search%"])
                ->orWhereRaw('LOWER(magasin_affecte) LIKE ?', ["%$search%"])
                ->orWhereRaw('LOWER(email) LIKE ?', ["%$search%"]);
            });
        }

        $users = $query->paginate($paginates);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();

        // Seul admin peut créer un utilisateur
        if (!$user->hasRole('admin')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à créer un utilisateur.');
        }
        $users = User::all();
        return view('users.create', compact('users'));
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
            'nom' => ['required', 'string', 'max:255', 'regex:/^[^,;:?!\.@&()$*#^{}<>+\/]+$/'],
            'nom_pseudo' => ['required', 'string', 'max:255', 'unique:users,nom_pseudo', 'regex:/^[^,;:\.?!@&()$*#^{}<>+\/]+$/'],
            'prenom' => ['required', 'string', 'max:255', 'regex:/^[^,;:\.?!@&()$*#^{}<>+\/]+$/'],
            'adresse' => ['required', 'string', 'max:255', 'regex:/^[^,;:\.?!@&()$*#^{}<>+\/]+$/'],
            'telephone' => ['required', 'regex:/^(70|71|72|73|74|75|76|77|78|79|90|91|92|93|94|95|96|97|98|99)[0-9]{6}$/', 'unique:users,telephone'],
            'magasin_affecte' => 'required|in:collation,technique,admin',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            $user = new User();

            // Transformer nom en majuscules
            $user->nom = mb_strtoupper($request->input('nom'));
            $user->nom_pseudo = ucfirst(mb_strtolower($request->input('nom_pseudo')));
            $user->prenom = ucfirst(mb_strtolower($request->input('prenom')));
            $user->adresse = ucfirst(mb_strtolower($request->input('adresse')));
            $user->telephone = $request->input('telephone');
            $user->magasin_affecte = $request->input('magasin_affecte');
            $user->email = mb_strtolower($request->input('email'));
            $user->password = Hash::make($request->input('password'));

            $user->save();

            // 🎯 Assigner automatiquement un rôle selon magasin_affecte
            if ($user->magasin_affecte === 'technique') {
                $user->assignRole('magasinier_technique');
            } elseif ($user->magasin_affecte === 'collation') {
                $user->assignRole('magasinier_collation');
            } elseif ($user->magasin_affecte === 'admin') {
                $user->assignRole('admin');
            }

            return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erreur lors de la création : ' . $e->getMessage()]);
        }
    }

    /**
     * Réactiver un utilisateur désactivé
     */
    public function restore(User $user)
    {
        $currentUser = auth()->user();

        if (!$currentUser->hasRole('admin')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à réactiver un utilisateur.');
        }

        // ✅ CORRIGÉ : Pas de restore() - juste mise à jour is_active
        $user->update([
            'is_active' => true,
            'deactivated_at' => null,
            'deactivation_reason' => null,
            'deactivated_by' => null,
        ]);

        return redirect()->route('users.index')
            ->with('success', "L'utilisateur {$user->nom} {$user->prenom} a été réactivé avec succès !");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $users = auth()->user();

        if (!($users->hasRole(['admin', 'magasinier_technique', 'magasinier_collation']))) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $users = auth()->user();

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

        if (!$users->hasRole('admin')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à modifier un utilisateur.');
        }
        $request->validate([
            'nom' => ['required', 'string', 'max:255', 'regex:/^[^,;:\.?!@&()$*#^{}<>+\/]+$/'],
            'nom_pseudo' => ['required', 'string', 'max:255', 'regex:/^[^,;:\.?!@&()$*#^{}<>+\/]+$/'],
            'prenom' => ['required', 'string', 'max:255', 'regex:/^[^,;:\.?!@&()$*#^{}<>+\/]+$/'],
            'adresse' => ['required', 'string', 'max:255', 'regex:/^[^,;:\.?!@&()$*#^{}<>+\/]+$/'],
            'telephone' => ['required', 'regex:/^(70|71|72|73|74|75|76|77|78|79|90|91|92|93|94|95|96|97|98|99)[0-9]{6}$/', 'unique:users,telephone,' . $user->user_id . ',user_id'],
            'magasin_affecte' => 'required|in:collation,technique,admin',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->user_id . ',user_id',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        try {
            $user->nom = $request->input('nom');
            $user->nom_pseudo = $request->input('nom_pseudo');
            $user->prenom = $request->input('prenom');
            $user->adresse = $request->input('adresse');
            $user->telephone = $request->input('telephone');
            $user->magasin_affecte = $request->input('magasin_affecte');
            $user->email = $request->input('email');

            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }

            $user->save();

            // 🎯 Met à jour le rôle selon le nouveau magasin_affecte
            $user->syncRoles([]);
            if ($user->magasin_affecte === 'technique') {
                $user->assignRole('magasinier_technique');
            } elseif ($user->magasin_affecte === 'collation') {
                $user->assignRole('magasinier_collation');
            } elseif ($user->magasin_affecte === 'admin') {
                $user->assignRole('admin');
            }

            return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erreur lors de la mise à jour : ' . $e->getMessage()]);
        }
    }

    /**
     * Désactiver un utilisateur (sans suppression physique)
     */
    public function destroy(User $user, Request $request)
    {
        $currentUser = auth()->user();

        if (!$currentUser->hasRole('admin')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à désactiver un utilisateur.');
        }

        if ($user->user_id === $currentUser->user_id) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas vous désactiver vous-même.');
        }

        if ($user->hasRole('admin')) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas désactiver un autre administrateur.');
        }

        $request->validate([
            'deactivation_reason' => 'required|string|min:10|max:500',
        ]);

        // ✅ CORRIGÉ : Mise à jour is_active SANS soft delete
        $user->update([
            'is_active' => false,
            'deactivated_at' => now(),
            'deactivation_reason' => $request->input('deactivation_reason'),
            'deactivated_by' => $currentUser->user_id,
        ]);

        // ✅ Révoquer les sessions actives (bloque immédiatement l'accès)
        \DB::table('sessions')->where('user_id', $user->user_id)->delete();

        return redirect()->route('users.index')
            ->with('success', "L'utilisateur {$user->nom} {$user->prenom} a été désactivé. Son statut est maintenant visible dans la liste.");
    }

    /**
     * Liste des utilisateurs désactivés (sans dépendance au soft delete)
     */
    public function desactives(Request $request)
    {
        $currentUser = auth()->user();

        if (!$currentUser->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Accès refusé. Seul un administrateur peut consulter cette page.');
        }

        $search = $request->input('search');
        $paginates = 10;

        // ✅ CORRIGÉ : Pas de onlyTrashed() - on filtre par is_active = false
        $query = User::where('is_active', false)
            ->orderBy('deactivated_at', 'desc');

        if ($search) {
            $search = strtolower($search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(nom) LIKE ?', ["%$search%"])
                  ->orWhereRaw('LOWER(nom_pseudo) LIKE ?', ["%$search%"])
                  ->orWhereRaw('LOWER(prenom) LIKE ?', ["%$search%"])
                  ->orWhereRaw('LOWER(email) LIKE ?', ["%$search%"]);
            });
        }

        $users = $query->paginate($paginates);

        return view('users.desactives', compact('users'));
    }
}