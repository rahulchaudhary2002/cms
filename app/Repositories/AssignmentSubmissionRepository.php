<?php

namespace App\Repositories;

use App\Interfaces\AssignmentSubmissionRepositoryInterface;
use App\Models\AssignmentSubmission;

class AssignmentSubmissionRepository implements AssignmentSubmissionRepositoryInterface
{
    public function create($request, $id)
    {
        return AssignmentSubmission::create([
            'assignment_id' => $id,
            'student_id' => auth()->user()->student->id,
            'submission_date' => now(),
        ]);
    }

    public function update($request, $assignment_id, $student_id)
    {
        return AssignmentSubmission::where('assignment_id', $assignment_id)
            ->where('student_id', $student_id)->update([
                'checked' => 1,
                'grade' => $request->overall_grade,
                'remarks' => $request->remarks
            ]);
    }
}
