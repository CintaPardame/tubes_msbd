<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'tagline',
        'about',
        'vision',
        'mission',
        'phone',
        'email',
        'address',
        'instagram',
    ];

    protected $casts = [
        'mission' => 'array',
    ];
}
