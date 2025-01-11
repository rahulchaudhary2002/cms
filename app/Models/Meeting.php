<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'topic',
        'meeting_id',
        'join_url',
        'start_time',
        'duration',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
