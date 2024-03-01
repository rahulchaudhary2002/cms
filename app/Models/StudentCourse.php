<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'semester_id', 'course_id'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
