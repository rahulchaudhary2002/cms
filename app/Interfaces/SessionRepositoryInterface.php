<?php

namespace App\Interfaces;
        
interface SessionRepositoryInterface extends BaseInterface
{
    public function getByActive($academicYear, $semester);
    public function getWithRelation($relation);
}
