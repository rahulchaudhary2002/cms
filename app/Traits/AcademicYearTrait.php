<?php

namespace App\Traits;

trait AcademicYearTrait
{
    public function getAcademicYears()
    {
        return $this->academicYearRepository->model()->get();
    }

    public function getAcademicYearWithSessions()
    {
        return $this->academicYearRepository->getWithSessions();
    }
}
