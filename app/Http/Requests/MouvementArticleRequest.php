<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MouvementArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            //
            'article_id'          => 'required|exists:articles,article_id',
            'origine'             => 'nullable|string',
            'quantite_commandee'  => 'required|integer|min:1',
            'quantite_entree'     => 'nullable|integer|min:1',
            'quantite_sortie'     => 'nullable|integer|min:1',
            'stock_debut_mois'    => 'required|integer|min:1',
            'avarie'              => 'nullable|integer|min:0',
            'observation'         => 'nullable|string',
            
        ];
    }
}
