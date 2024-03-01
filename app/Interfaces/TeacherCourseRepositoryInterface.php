<?php

namespace App\Interfaces;
        
interface TeacherCourseRepositoryInterface
{
    public function assign($request, $id);
}