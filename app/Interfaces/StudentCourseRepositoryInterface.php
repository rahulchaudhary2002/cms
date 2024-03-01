<?php

namespace App\Interfaces;
        
interface StudentCourseRepositoryInterface
{
    public function assign($request, $semester, $student_id);
}