<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mouvement;

class Consommation extends Model
{
    use HasFactory;

    protected $primaryKey = 'consommation_id';

    protected $fillable = [
        'produit_id',
        'annee',

        'consommation_janvier', 'rupture_janvier',
        'consommation_fevrier', 'rupture_fevrier',
        'consommation_mars',    'rupture_mars',
        'consommation_avril',   'rupture_avril',
        'consommation_mai',     'rupture_mai',
        'consommation_juin',    'rupture_juin',
        'consommation_juillet', 'rupture_juillet',
        'consommation_aout',    'rupture_aout',
        'consommation_septembre', 'rupture_septembre',
        'consommation_octobre',   'rupture_octobre',
        'consommation_novembre',  'rupture_novembre',
        'consommation_decembre',  'rupture_decembre',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id', 'produit_id');
    }

    // Calcul automatique du total annuel
    public function getTotalAnnuelAttribute()
    {
        return collect([
            $this->consommation_janvier, $this->consommation_fevrier, $this->consommation_mars,
            $this->consommation_avril,   $this->consommation_mai,     $this->consommation_juin,
            $this->consommation_juillet, $this->consommation_aout,    $this->consommation_septembre,
            $this->consommation_octobre, $this->consommation_novembre, $this->consommation_decembre,
        ])->sum();
    }

    // Trimestres
    public function getTrimestre1Attribute()
    {
        return $this->consommation_janvier + $this->consommation_fevrier + $this->consommation_mars;
    }

    public function getTrimestre2Attribute()
    {
        return $this->consommation_avril + $this->consommation_mai + $this->consommation_juin;
    }

    public function getTrimestre3Attribute()
    {
        return $this->consommation_juillet + $this->consommation_aout + $this->consommation_septembre;
    }

    public function getTrimestre4Attribute()
    {
        return $this->consommation_octobre + $this->consommation_novembre + $this->consommation_decembre;
    }

    // Semestres
    public function getSemestre1Attribute()
    {
        return $this->trimestre1 + $this->trimestre2;
    }

    public function getSemestre2Attribute()
    {
        return $this->trimestre3 + $this->trimestre4;
    }

    public static function recalcForProductYear(int $produit_id, int $annee): void
    {
        // SQLite-compatible date extraction
        $mensuelles = Mouvement::selectRaw("CAST(strftime('%m', date) AS INTEGER) as mois, SUM(quantite_sortie) as total")
            ->where('produit_id', $produit_id)
            ->whereYear('date', $annee)
            ->whereNotNull('quantite_sortie')
            ->where('quantite_sortie', '>', 0)
            ->groupByRaw("CAST(strftime('%m', date) AS INTEGER)")
            ->pluck('total', 'mois'); // [1 => 120, 4 => 55, etc.]

        $moisNoms = [
            1 => 'janvier',   2 => 'fevrier',  3 => 'mars',
            4 => 'avril',     5 => 'mai',      6 => 'juin',
            7 => 'juillet',   8 => 'aout',     9 => 'septembre',
            10 => 'octobre', 11 => 'novembre', 12 => 'decembre',
        ];

        $data = [];
        foreach ($moisNoms as $mois => $nom) {
            $data["consommation_$nom"] = $mensuelles[$mois] ?? 0;
           
        }

        $cons = static::firstOrNew([
            'produit_id' => $produit_id,
            'annee'      => $annee,
        ]);

        $cons->fill($data)->save();
    }
}