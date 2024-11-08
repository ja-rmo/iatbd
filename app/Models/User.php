<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'blocked',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function pets()
    {
        return $this->hasMany(Pet::class, 'owner_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'sitter_id');
    }

    public function house()
    {
        return $this->hasOne(House::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, );
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
