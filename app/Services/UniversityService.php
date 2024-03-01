<?php

namespace App\Services;

use App\Interfaces\UniversityRepositoryInterface;

class UniversityService
{
    private UniversityRepositoryInterface $universityRepository;

    public function __construct(UniversityRepositoryInterface $universityRepository) {
        $this->universityRepository = $universityRepository;
    }

    public function getUniversities($request)
    {
        return $this->universityRepository->get($request);
    }

    public function getUniversityByKey($key)
    {
        return $this->universityRepository->getByKey($key);
    }

    public function createUniversity($request)
    {
        return $this->universityRepository->create($request);
    }

    public function updateUniversity($request, $key)
    {
        return $this->universityRepository->update($request, $key);
    }
}
