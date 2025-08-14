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
            'stockmax'        => 'nullable|integer',
            'stockmin'        => 'nullable|integer',
            'stocksecurite'   => 'required|integer',
            'dateperemption'  => 'nullable|date',
            'lot'             => 'nullable|string|max:255',
        ];

        if ($this->isMethod('post')) {
            $rules['user_id'] = 'required|integer|exists:users,user_id';
        }

        return $rules;
    }
}
