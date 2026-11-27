<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'origin_id',
        'category_id',
        'name',
        'slug',
        'roast_level',
        'process_method',
        'price',
        'min_price',
        'weight_grams',
        'stock',
        'flavor_notes',
        'description',
        'is_popular',
        'main_image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'min_price' => 'decimal:2',
        'is_popular' => 'boolean',
        'weight_grams' => 'integer',
        'stock' => 'integer',
    ];

    public function promotions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Promotion::class);
    }

    public function roastingBatches(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RoastingBatch::class);
    }

    public function origin(): BelongsTo
    {
        return $this->belongsTo(Origin::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
