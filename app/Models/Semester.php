<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'key',
        'program_id',
        'order',
        'number_of_elective_courses'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function compulsoryCourses()
    {
        return $this->hasMany(Course::class)->where('elective', 0);
    }

    public function electiveCourses()
    {
        return $this->hasMany(Course::class)->where('elective', 1);
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function studentSemesters()
    {
        return $this->hasMany(StudentSemester::class);
    }
}
