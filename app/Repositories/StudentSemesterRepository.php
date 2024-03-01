<?php

namespace App\Repositories;

use App\Interfaces\StudentSemesterRepositoryInterface;
use App\Models\StudentSemester;

class StudentSemesterRepository implements StudentSemesterRepositoryInterface
{
    public function assign($request, $id)
    {
        return StudentSemester::create([
            'student_id' => $id,
            'semester_id' => $request->semester,
            'session_id' => $request->session
        ]);
    }
}
