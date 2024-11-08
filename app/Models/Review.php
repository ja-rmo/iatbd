<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'rating',
        'comment',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
