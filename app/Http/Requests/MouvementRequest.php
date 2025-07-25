<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MouvementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'produit_id'          => 'required|exists:produits,produit_id',
            'origine'             => 'nullable|string',
            'quantite_commandee'  => 'required|integer|min:1',
            'quantite_entree'     => 'nullable|integer|min:1',
            'quantite_sortie'     => 'nullable|integer|min:1',
            'stock_debut_mois'    => 'required|integer|min:1',
            'avarie'              => 'nullable|integer|min:0',
            'observation'         => 'nullable|string',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $entree = $this->input('quantite_entree');
            $sortie = $this->input('quantite_sortie');

            if ($entree && $sortie) {
                $validator->errors()->add('quantite_entree', 'Vous ne pouvez pas saisir une entrée et une sortie en même temps.');
            }

            if (!$entree && !$sortie) {
                $validator->errors()->add('quantite_entree', 'Vous devez saisir soit une entrée, soit une sortie.');
            }
        });
    }
}
