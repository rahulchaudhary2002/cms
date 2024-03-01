<?php

namespace App\Repositories;

use App\Interfaces\TeacherCourseRepositoryInterface;
use App\Models\TeacherCourse;

class TeacherCourseRepository implements TeacherCourseRepositoryInterface
{
    public function assign($request, $id)
    {
        return TeacherCourse::create([
            'teacher_id' => $id,
            'session_id' => $request->session,
            'course_id' => $request->course
        ]);
    }
}
