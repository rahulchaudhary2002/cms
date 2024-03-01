<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'academic_year_id', 'program_id', 'course_id', 'semester_id', 'session_id', 'title', 'description', 'late_submission', 'date_given', 'submission_date'];

    protected $dates = ['date_given', 'submission_date'];

    public function questions()
    {
        return $this->hasMany(AssignmentQuestion::class);
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    public function authSubmission()
    {
        return $this->hasOne(AssignmentSubmission::class)->where('student_id', auth()->user()->student->id);
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
        return $this->belongsTo(Semester::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function creater()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
