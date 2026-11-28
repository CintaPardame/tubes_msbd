<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyCashierSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'cashier_id',
        'closing_date',
        'total_transactions',
        'total_revenue',
        'notes',
        'status',
    ];

    protected $casts = [
        'closing_date' => 'date',
        'total_transactions' => 'integer',
        'total_revenue' => 'decimal:2',
    ];

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'closed' => 'Tutup Buku Selesai',
            'submitted_to_admin' => 'Diserahkan ke Admin',
            'verified_by_admin' => 'Diverifikasi Admin',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }
}
