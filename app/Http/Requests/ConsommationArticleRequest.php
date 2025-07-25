<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsommationArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'article_id' => 'required|exists:articles,article_id',
            'annee'      => 'required|integer|min:2020|max:'.(date('Y')+1),
        ];

        foreach ([
            'janvier', 'fevrier', 'mars', 'avril', 'mai', 'juin',
            'juillet', 'aout', 'septembre', 'octobre', 'novembre', 'decembre'
        ] as $mois) {
            $rules["consommation_$mois"] = 'required|integer|min:0';
            $rules["rupture_$mois"]      = 'required|integer|min:0';
        }

        return $rules;
    }
}
