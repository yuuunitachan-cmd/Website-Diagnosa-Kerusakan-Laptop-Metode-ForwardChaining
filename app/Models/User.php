<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email', 
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is regular user
     */
    public function isUser()
    {
        return $this->role === 'user';
    }

    /**
     * Relationship with histories
     */
    public function histories()
    {
        return $this->hasMany(History::class);
    }

    /**
     * Get latest diagnosa history
     */
    public function latestHistory()
    {
        return $this->hasOne(History::class)->latest();
    }

    /**
     * Get total diagnosa count
     */
    public function getTotalDiagnosaAttribute()
    {
        return $this->histories()->count();
    }
}