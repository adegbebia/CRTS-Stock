<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'codearticle'     => ['bail','required','string','max:255','not_regex:/[ ,;:\.?!=%@&()$*#^{}<>+\/\s]/'],
            'libelle'         => ['bail','required','string','max:255','not_regex:/[,;:\.?!=%@&()$*#^{}<>+\/]/'], 
            'conditionnement' => ['bail','required','string','max:255','not_regex:/[,;:\.?!=%@&()$*#^{}<>+\/]/'], 
            'quantitestock'   => ['required','integer','min:0'],
            'stockmax'        => ['required','integer','min:1'],
            'stockmin'        => ['required','integer','min:0'],
            'stocksecurite'   => ['required','integer','min:0'],
            'dateperemption'  => ['nullable','date','after:today'],
            'lot'             => ['nullable','string','max:255','not_regex:/[ ,;:\.?!=%@&()$*#^{}<>+\/\s]/'],
        ];

        if ($this->isMethod('post')) {
            $rules['user_id'] = 'required|integer|exists:users,user_id';
        }

        return $rules;
    }

    // public function withValidator($validator)
    // {
    //     $validator->after(function ($validator) {
    //     $quantite = (int) $this->input('quantitestock');
    //     $stockMax = (int) $this->input('stockmax');
    //     $stockMin = (int) $this->input('stockmin');
    //     $stockSecurite = (int) $this->input('stocksecurite');

    //         // Vérification que la quantité ne dépasse pas le stock maximum
    //         if ($quantite > $stockMax) {
    //             $validator->errors()->add('quantitestock', 'La quantité ne peut pas dépasser le stock maximum.');
    //         }

    //         // Vérification que le stock minimum ne dépasse pas le stock maximum
    //         if ($stockMin > $stockMax) {
    //             $validator->errors()->add('stockmin', 'Le stock minimum ne peut pas dépasser le stock maximum.');
    //         }

    //         // Vérification que le stock de sécurité ne dépasse pas le stock maximum
    //         if ($stockSecurite > $stockMax) {
    //             $validator->errors()->add('stocksecurite', 'Le stock de sécurité ne peut pas dépasser le stock maximum.');
    //         }
    //     });
    }


