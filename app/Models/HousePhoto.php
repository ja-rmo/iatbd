<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HousePhoto extends Model
{
    use HasFactory;

    protected $fillable = ['house_id','url'];

    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
