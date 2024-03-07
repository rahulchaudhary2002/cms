<?php

namespace App\Traits;

trait SessionTrait
{
    public function getSessionsWithAcademicYearSemesterAndProgram()
    {
        $user = $this->userRepository->getById(auth()->user()->id);

        if ($user->hasRole('superadmin')) {
            return $this->sessionRepository->getWithRelation(['academicYear', 'semester', 'program']);
        }

        if ($user->hasRole('teacher')) {
            return $this->sessionRepository->model()->with(['academicYear', 'semester', 'program'])->whereHas('teacherCourses', function ($query) use ($user) {
                $query->where('teacher_id', $user->teacher->id);
            })->get();
        }

        if ($user->hasRole('student')) {
            // return $this->sessionRepository->model()->with(['academicYear', 'semester', 'program'])->whereHas('studentSemesters', function ($query) use ($user) {
            //     $query->where('student_id', $user->student->id);
            // })->get();

            return [];
        }

        return $this->sessionRepository->getWithRelation(['academicYear', 'semester', 'program']);
    }
}
