<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'species',
        'description',
        'photo'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function SittingRequests()
    {
        return $this->hasMany(SittingRequest::class, 'pet_id');
    }
}
