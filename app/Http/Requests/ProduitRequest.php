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
            'codeproduit'      => ['bail','required','not_regex:/[ ,;:\.?!=%@&()$*#^{}<>+\/\s]/'],
            'libelle' => ['bail','required','not_regex:/[,;:\.?!=%@&()$*#^{}<>+\/]/'],
            'conditionnement' => ['bail','required','not_regex:/[,;:\.?!=%@&()$*#^{}<>+\/]/'],
            'quantitestock'    => ['required','integer','min:0'],
            'stockmax'         => ['required','integer','min:0'],
            'stocksecurite'    => ['required','integer','min:0'],
            'dateperemption'   => ['nullable','date','after:today'],
            'lot'              => ['nullable','not_regex:/[ ,;:\.?!=%@&()$*#^{}<>+\/\s]/'],
        ];

        

        // Si c’est pour la création, ajouter la validation de user_id
        if ($this->isMethod('post')) {
            $rules['user_id'] = 'required|integer|exists:users,user_id';
        }

        return $rules;
    }
}
