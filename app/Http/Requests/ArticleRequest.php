<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
        $rules= [
            //
            'codearticle'     => 'required|string|max:255',
            'libelle'         => 'required|string|max:255',
            'conditionnement' => 'required|string|max:255',
            'quantitestock'   => 'required|integer',
            'stockmax'        => 'required|integer',
            'stockmin'        => 'required|integer',
            'stocksecurite'   => 'required|integer',
            'dateperemption'  => 'required|date',
            'lot'             => 'required|string|max:255',
        ];

        if ($this->isMethod('post')) {
            $rules['user_id'] = 'required|integer|exists:users,user_id';
        }

        return $rules;
    }
}
