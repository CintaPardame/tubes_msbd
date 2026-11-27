<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supply extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bean_type',
        'origin_name',
        'weight_kg',
        'purchase_cost_per_kg',
        'total_purchase_cost',
        'status',
        'admin_notes',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'weight_kg' => 'decimal:2',
        'purchase_cost_per_kg' => 'decimal:2',
        'total_purchase_cost' => 'decimal:2',
        'approved_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function roastingBatches(): HasMany
    {
        return $this->hasMany(RoastingBatch::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'Menunggu Persetujuan',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            default => ucfirst($this->status),
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'bg-amber-100 text-amber-800',
            'disetujui' => 'bg-emerald-100 text-emerald-800',
            'ditolak' => 'bg-rose-100 text-rose-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
