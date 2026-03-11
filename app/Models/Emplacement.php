<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Emplacement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'zone',
        'allee',
        'occupe',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'occupe' => 'boolean',
        ];
    }

    /**
     * Get the colis for the emplacement.
     */
    public function colis(): HasMany
    {
        return $this->hasMany(Colis::class);
    }
}
