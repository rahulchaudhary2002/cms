<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExaminationMark extends Model
{
    use HasFactory;

    protected $fillable = [
        'examination_record_id', 'course_id', 'grade'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
