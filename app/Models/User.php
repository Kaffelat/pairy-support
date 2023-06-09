<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
    * The attributes that are mass assignable.
    */
    protected $fillable = [
        'name',
        'email',
        'openai_api_key',
        'password',
        'admin'
    ];

    /**
    * The attributes that should be hidden for serialization.
    */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $guarded = [
        'admin'
    ];

    /**
    * Relation to AI Model
    */
    public function aiModel(): HasMany
    {
        return $this->hasMany(AIModel::class, 'user_id');
    }
    /**
    * Relation to AI Model
    */
    public function aiFile(): HasMany
    {
        return $this->hasMany(AIFile::class, 'user_id');
    }
}
