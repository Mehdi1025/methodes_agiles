<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transporteur extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'contact',
        'delai_moyen_jours',
    ];

    /**
     * Get the colis for the transporteur.
     */
    public function colis(): HasMany
    {
        return $this->hasMany(Colis::class);
    }
}
