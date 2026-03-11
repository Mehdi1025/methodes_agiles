<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Colis extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code_qr',
        'description',
        'poids_kg',
        'dimensions',
        'statut',
        'date_reception',
        'date_expedition',
        'fragile',
        'client_id',
        'transporteur_id',
        'emplacement_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'poids_kg' => 'decimal:2',
            'date_reception' => 'date',
            'date_expedition' => 'date',
            'fragile' => 'boolean',
        ];
    }

    /**
     * Get the client that owns the colis.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the transporteur that owns the colis.
     */
    public function transporteur(): BelongsTo
    {
        return $this->belongsTo(Transporteur::class);
    }

    /**
     * Get the emplacement that owns the colis.
     */
    public function emplacement(): BelongsTo
    {
        return $this->belongsTo(Emplacement::class);
    }

    /**
     * Get the historique mouvements for the colis.
     */
    public function historiqueMouvements(): HasMany
    {
        return $this->hasMany(HistoriqueMouvement::class);
    }
}
