<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Article;

class MouvementArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'article_id'          => 'required|exists:articles,article_id',
            'origine'             => 'nullable|string',
            'quantite_commandee'  => 'nullable|integer|min:1',
            'quantite_entree'     => 'nullable|integer|min:1',
            'quantite_sortie'     => 'nullable|integer|min:1',
            // 'stock_debut_mois'    => 'required|integer|min:1',
            'avarie'              => 'nullable|integer|min:0',
            'observation'         => 'nullable|string',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $entree = $this->input('quantite_entree');
            $sortie = $this->input('quantite_sortie');
            $article_id = $this->input('article_id');

            if ($entree && $sortie) {
                $validator->errors()->add('quantite_entree', 'Vous ne pouvez pas saisir une entrée et une sortie en même temps.');
            }

            if (!$entree && !$sortie) {
                $validator->errors()->add('quantite_entree', 'Vous devez saisir soit une entrée, soit une sortie.');
            }
            if ($sortie) {
                $article = Article::find($article_id);
                if ($article && $sortie > $article->quantitestock) {
                    $validator->errors()->add('quantite_sortie', 'La quantité sortie ne peut pas dépasser le stock disponible (' . $article->quantitestock . ').');
                }
            }
        });
    }
}
