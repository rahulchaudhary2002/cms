<?php

namespace App\Services;

use App\Interfaces\AcademicYearRepositoryInterface;

class AcademicYearService
{
    private AcademicYearRepositoryInterface $academicYearRepository;

    public function __construct(AcademicYearRepositoryInterface $academicYearRepository) {
        $this->academicYearRepository = $academicYearRepository;
    }

    public function getAcademicYears($request)
    {
        return $this->academicYearRepository->get($request);
    }

    public function getAcademicYearByKey($key)
    {
        return $this->academicYearRepository->getByKey($key);
    }

    public function createAcademicYear($request)
    {
        return $this->academicYearRepository->create($request);
    }

    public function updateAcademicYear($request, $key)
    {
        return $this->academicYearRepository->update($request, $key); 
    }
}
