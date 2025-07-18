<?php

namespace App\Http\Controllers;

use App\Models\Consommation;
use App\Models\Produit;
use App\Models\Mouvement;
use Illuminate\Http\Request;
use App\Http\Requests\ConsommationRequest;

class ConsommationController extends Controller
{
    /* /consommations → redirige vers create */
    public function index()
    {
        // Vérifiez si l'utilisateur a la permission de voir les consommations
        if (!auth()->user()->can('consommations-view')) {
            abort(403, 'Accès refusé');
        }
        return redirect()->route('consommations.create');
    }

    public function create(Request $request)
    {
        // Vérifiez si l'utilisateur a la permission de créer des consommations
        if (!auth()->user()->can('consommations-create')) {
            abort(403, 'Accès refusé');
        }

        // Le reste de votre logique...
    }

    public function store(ConsommationRequest $request)
    {
        // Vérifiez si l'utilisateur a la permission de créer des consommations
        if (!auth()->user()->can('consommations-create')) {
            abort(403, 'Accès refusé');
        }

        // Le reste de votre logique...
    }

    public function edit(Consommation $consommation)
    {
        // Vérifiez si l'utilisateur a la permission de modifier des consommations
        if (!auth()->user()->can('consommations-edit')) {
            abort(403, 'Accès refusé');
        }

        // Le reste de votre logique...
    }

    public function update(ConsommationRequest $request, Consommation $consommation)
    {
        // Vérifiez si l'utilisateur a la permission de modifier des consommations
        if (!auth()->user()->can('consommations-edit')) {
            abort(403, 'Accès refusé');
        }

        // Le reste de votre logique...
    }

    public function destroy(Consommation $consommation)
    {
        // Vérifiez si l'utilisateur a la permission de supprimer des consommations
        if (!auth()->user()->can('consommations-delete')) {
            abort(403, 'Accès refusé');
        }

    }

}
