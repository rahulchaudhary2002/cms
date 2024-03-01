<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['assignment_submission_id', 'assignment_question_id', 'answer', 'uploads', 'comment'];

    public function submission()
    {
        return $this->belongsTo(AssignmentSubmission::class);
    }

    public function question()
    {
        return $this->belongsTo(AssignmentQuestion::class);
    }
}
