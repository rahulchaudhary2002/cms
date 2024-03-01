<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['assignment_id', 'question', 'description', 'answer_type', 'multiple_upload'];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function answers()
    {
        return $this->hasMany(AssignmentAnswer::class);
    }
}
