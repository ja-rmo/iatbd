<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SittingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'start_date',
        'end_date',
        'message',
        'rate',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'sitting_request_id');
    }
}
