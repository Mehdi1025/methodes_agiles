<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoriqueMouvement extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'colis_id',
        'user_id',
        'ancien_statut',
        'nouveau_statut',
        'date_mouvement',
        'commentaire',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_mouvement' => 'datetime',
        ];
    }

    /**
     * Get the colis that owns the historique mouvement.
     */
    public function colis(): BelongsTo
    {
        return $this->belongsTo(Colis::class);
    }

    /**
     * Get the user that owns the historique mouvement.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
