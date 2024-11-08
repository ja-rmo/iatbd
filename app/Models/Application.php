<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'sitting_request_id',
        'sitter_id',
        'status',
        'message',
    ];

    public function sitter()
    {
        return $this->belongsTo(User::class, 'sitter_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function sitting_request()
    {
        return $this->belongsTo(SittingRequest::class, 'sitting_request_id');
    }
}
