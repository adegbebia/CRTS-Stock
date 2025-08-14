<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProduitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // à adapter si tu as une logique d'autorisation
    }

    public function rules(): array
    {
        $rules = [
            'codeproduit'     => 'required|string|max:255',
            'libelle'         => 'required|string|max:255',
            'conditionnement' => 'required|string|max:255',
            'quantitestock'   => 'required|integer',
            'stockmax'        => 'required|integer',
            'stockmin'        => 'required|integer',
            'stocksecurite'   => 'required|integer',
            'dateperemption'  => 'nullable|date',
            'lot'             => 'nullable|string|max:255',
        ];

        

        // Si c’est pour la création, ajouter la validation de user_id
        if ($this->isMethod('post')) {
            $rules['user_id'] = 'required|integer|exists:users,user_id';
        }

        return $rules;
    }
}
