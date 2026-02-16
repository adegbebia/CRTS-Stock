<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

// /**
//  * @method bool hasRole(string|array $role)
//  * @method bool hasAnyRole(array|string ...$roles)
//  * @method \Spatie\Permission\Models\Role[] getRoleNames()
//  */



class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasRoles,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */


    protected $primaryKey ='user_id';

    protected $fillable = [
        'datecreation',
        'nom',
        'nom_pseudo',
        'prenom',
        'adresse',
        'telephone',
        'magasin_affecte',
        'email',
        'password',
        'is_active', 
        'deactivation_reason', 
        'deactivated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'deactivated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function deactivatedBy()
    {
        return $this->belongsTo(User::class, 'deactivated_by', 'user_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->whereNull('deleted_at');
    }

    public function canBeDeactivated(): bool
    {
        return !$this->produits()->exists() && 
               !$this->articles()->exists() &&
               !$this->consommations()->exists() &&
               !$this->consommationsarticles()->exists();
    }

    public function mouvements():HasMany{

        return $this->hasMany(MouvementProduit::class,'user_id','user_id');
    }

    public function produits():HasMany{

        return $this->hasMany(Produit::class,'user_id');
    }

    public function mouvementsarticles():HasMany{

        return $this->hasMany(MouvementArticle::class,'user_id');
    }

    public function articles():HasMany{

        return $this->hasMany(Article::class,'user_id');
    }

    public function consommations()
    {
        return $this->hasMany(ConsommationProduit::class, 'user_id', 'user_id');
    }

    public function consommationsarticles()
    {
        return $this->hasMany(ConsommationArticle::class, 'user_id', 'user_id');
    }
}
