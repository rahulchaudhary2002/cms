<?php

namespace App\Interfaces;
        
interface AcademicYearRepositoryInterface extends BaseInterface
{
    public function getWithSessions();
}
