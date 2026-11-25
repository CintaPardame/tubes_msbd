<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplyOffer extends Model
{
    protected $fillable = [
        'user_id',
        'origin_id',
        'variety',
        'process_method',
        'harvest_date',
        'quantity_kg',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function origin()
    {
        return $this->belongsTo(Origin::class);
    }
}