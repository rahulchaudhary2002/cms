<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExaminationStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'key', 'academic_year_id', 'program_id', 'semester_id', 'session_id', 'start_date', 'end_date'
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

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
