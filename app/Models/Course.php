<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'key',
        'course_code',
        'program_id',
        'semester_id',
        'elective',
        'credit'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function teacherCourses()
    {
        return $this->hasMany(TeacherCourse::class);
    }

    public function studentCourses()
    {
        return $this->hasMany(StudentCourse::class);
    }
}
