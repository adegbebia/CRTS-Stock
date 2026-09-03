<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Produit;

class MouvementRequest extends FormRequest
{
    public function authorize(): bool
    {
       return true;
    }

    public function rules(): array
    {
        return [
            'produit_id'             => ['required', 'exists:produits,produit_id'],
            'origine'                => ['nullable', 'string', 'max:255', 'not_regex:/[,;:\.?!=%@&()$*#^{}<>+\/]/'],
            'quantite_commandee'     => ['nullable','integer','min:1'],
            'quantite_entree'        => ['nullable','integer','min:1'],
            'quantite_sortie'        => ['nullable','integer','min:1'],
            // 'stock_debut_mois'    => 'required|integer|min:0',
            'avarie'                 => ['nullable','integer','min:0'],
            'nombre_rupture_stock'   => ['nullable','integer','min:0'],
            'observation'            => ['nullable','string','max:255','not_regex:/[,;:\.?!=%@&()$*#^{}<>+\/]/'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $entree = $this->input('quantite_entree');
            $sortie = $this->input('quantite_sortie');
            $produit_id = $this->input('produit_id');

            if ($entree && $sortie) {
                $validator->errors()->add('quantite_entree', 'Vous ne pouvez pas saisir une entrée et une sortie en même temps.');
            }

            if (!$entree && !$sortie) {
                $validator->errors()->add('quantite_entree', 'Vous devez saisir soit une entrée, soit une sortie.');
            }

            if ($sortie) {
                $produit = Produit::find($produit_id);
                if ($produit && $sortie > $produit->quantitestock) {
                    $validator->errors()->add('quantite_sortie', 'La quantité sortie ne peut pas dépasser le stock disponible (' . $produit->quantitestock . ').');
                }
            }
        });
    }
}
