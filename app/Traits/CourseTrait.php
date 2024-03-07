<?php

namespace App\Traits;
        
trait CourseTrait
{
    public function getCourses()
    {
        return $this->courseRepository->model()->get();
    }
    
    public function getCoursesWithSemester()
    {
        $user = $this->userRepository->getById(auth()->user()->id);

        if ($user->hasRole('superadmin')) {
            return $this->courseRepository->getWithRelation(['semester']);
        }

        if ($user->hasRole('teacher')) {
            return $this->courseRepository->model()->with(['semester', 'teacherCourses.session'])->whereHas('teacherCourses', function ($query) use ($user) {
                $query->where('teacher_id', $user->teacher->id);
            })->get();
        }

        if($user->hasRole('student')) {
            return $this->courseRepository->model()->with(['semester'])->whereHas('studentCourses', function ($query) use ($user) {
                $query->where('student_id', $user->student->id);
            })->get();
        }

        return $this->courseRepository->getWithRelation(['semester']);
    }
}
