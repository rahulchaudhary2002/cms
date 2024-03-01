<?php

namespace App\Interfaces;
        
interface AssignmentSubmissionRepositoryInterface
{
    public function create($request, $id);
    public function update($request, $assignment_id, $student_id);
}
