<?php

namespace App\Models;


use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Note;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use HasFactory, Authenticatable, Authorizable;
    
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    protected $hidden = [
        'password'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function note(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}

