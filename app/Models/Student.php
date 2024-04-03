<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'academic_year_id',
        'program_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
        return $this->hasOne(StudentSemester::class)->latestOfMany();
    }

    public function semesters()
    {
        return $this->hasMany(StudentSemester::class);
    }

    public function studentCourses()
    {
        return $this->hasMany(StudentCourse::class);
    }

    public function attendances()
    {
        return $this->hasMany(StudentAttendance::class);
    }

    public function examinationRecords()
    {
        return $this->hasMany(ExaminationRecord::class);
    }
}
