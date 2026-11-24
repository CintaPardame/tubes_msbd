<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'level',
        'phone',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'level' => 'integer',
        ];
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin' || $this->level === 1;
    }

    public function isKasir(): bool
    {
        return $this->role === 'kasir';
    }

    public function isPetani(): bool
    {
        return $this->role === 'petani';
    }

    public function isUser(): bool
    {
        return $this->role === 'user' || $this->level === 3;
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'Admin (Level 1)',
            'kasir' => 'Kasir (Level 2)',
            'petani' => 'Petani / Produsen (Level 2)',
            default => 'Konsumen / User (Level 3)',
        };
    }
}
