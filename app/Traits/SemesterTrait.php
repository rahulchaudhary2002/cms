<?php

namespace App\Traits;
        
trait SemesterTrait
{
    public function getSemesters() 
    {
        return $this->semesterRepository->model()->get();
    }
    
    public function getSemestersWithProgram()
    {
        $user = $this->userRepository->getById(auth()->user()->id);

        if($user->hasRole('student')) {
            return $this->semesterRepository->model()->with('program')->whereHas('studentSemesters', function ($query) use ($user) {
                $query->where('student_id', $user->student->id);
            })->get();
        }

        return $this->semesterRepository->getWithRelation('program');
    }
}
