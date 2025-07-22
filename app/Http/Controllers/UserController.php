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
        //
        $users=User::all();
        return view('users.index',compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        $users=User::all();
        return view('users.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => ['required', 'regex:/^(70|71|72|73|74|75|76|77|78|79|90|91|92|93|94|95|96|97|98|99)[0-9]{6}$/'],
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

            // Email en minuscules
            $user->email = mb_strtolower($request->input('email'));

            // Password hashé
            $user->password = Hash::make($request->input('password'));

            $user->save();

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
        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => ['required', 'regex:/^(70|71|72|73|74|75|76|77|78|79|90|91|92|93|94|95|96|97|98|99)[0-9]{6}$/'],
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->user_id . ',user_id',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        try {
            $user->nom = $request->input('nom');
            $user->prenom = $request->input('prenom');
            $user->adresse = $request->input('adresse');
            $user->telephone = $request->input('telephone');
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
        //

        // dd($user);
        try {

            $user->delete();
            return redirect()->route('users.index')->with('success','Employe(é) supprimé avec succés. !');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la suppression.']);
        }
        
        
    }
}
