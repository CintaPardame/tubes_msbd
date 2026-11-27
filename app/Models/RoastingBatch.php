<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoastingBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'supply_id',
        'product_id',
        'green_bean_weight_kg',
        'shrinkage_percentage',
        'roasted_weight_kg',
        'packages_produced',
        'roasting_cost',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'green_bean_weight_kg' => 'decimal:2',
        'shrinkage_percentage' => 'decimal:2',
        'roasted_weight_kg' => 'decimal:2',
        'packages_produced' => 'integer',
        'roasting_cost' => 'decimal:2',
    ];

    public function supply(): BelongsTo
    {
        return $this->belongsTo(Supply::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
