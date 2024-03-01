<?php

namespace App\Interfaces;
        
interface CourseRepositoryInterFace extends BaseInterface
{
    public function getWithRelation($relation);
}