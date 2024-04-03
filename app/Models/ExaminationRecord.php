<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExaminationRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'examination_stage_id', 'gpa'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function examinationStage()
    {
        return $this->belongsTo(ExaminationStage::class);
    }
}
