<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'key', 'is_active', 'program_id', 'semester_id', 'academic_year_id'
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

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

    public function studentSemesters()
    {
        return $this->hasMany(StudentSemester::class);
    }
}
