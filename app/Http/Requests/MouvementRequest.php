<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MouvementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;   // adapte si besoin d’autorisation
    }

    public function rules(): array
    {
        return [
            'produit_id'          => 'required|exists:produits,produit_id',
            'origine'             => 'nullable|string',
            'quantite_commandee'  => 'required|integer|min:1',
            'quantite_sortie'     => 'nullable|integer|min:1',
            'stock_debut_mois'    => 'required|integer|min:1',
            'stock_debut_mois'    => 'required|integer|min:1',
            'avarie'              => 'nullable|integer|min:0',
            'observation'         => 'nullable|string',
        ];
    }
}
