<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id'
    ];

    public function teacherCourses()
    {
        return $this->hasMany(TeacherCourse::class);
    }
}
