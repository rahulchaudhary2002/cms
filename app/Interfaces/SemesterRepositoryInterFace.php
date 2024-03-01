<?php

namespace App\Interfaces;
        
interface SemesterRepositoryInterFace extends BaseInterface
{
    public function getWithRelation($relation);
    public function getByProgramAndOrder($program, $order);
}