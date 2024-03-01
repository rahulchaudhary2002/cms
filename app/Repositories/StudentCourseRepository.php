<?php

namespace App\Repositories;

use App\Interfaces\StudentCourseRepositoryInterface;
use App\Models\StudentCourse;
use Exception;

class StudentCourseRepository implements StudentCourseRepositoryInterface
{
    public function assign($request, $semester, $student_id)
    {
        try {
            foreach ($semester->compulsoryCourses as $course) {
                StudentCourse::create([
                    'student_id' => $student_id,
                    'semester_id' => $semester->id,
                    'course_id' => $course->id
                ]);
            }

            if ($semester->number_of_elective_courses > 0) {
                foreach ($request->elective_courses as $course) {
                    StudentCourse::create([
                        'student_id' => $student_id,
                        'semester_id' => $semester->id,
                        'course_id' => $course
                    ]);
                }
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
