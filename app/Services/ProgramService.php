<?php

namespace App\Services;

use App\Interfaces\ProgramRepositoryInterFace;
use App\Interfaces\UniversityRepositoryInterface;

class ProgramService
{
    private ProgramRepositoryInterFace $programRepository;
    private UniversityRepositoryInterface $universityRepository;

    public function __construct(ProgramRepositoryInterface $programRepository, UniversityRepositoryInterface $universityRepository) {
        $this->programRepository = $programRepository;
        $this->universityRepository = $universityRepository;
    }

    public function getPrograms($request)
    {
        return $this->programRepository->get($request);
    }

    public function getProgramByKey($key)
    {
        return $this->programRepository->getByKey($key);
    }

    public function createProgram($request)
    {
        return $this->programRepository->create($request);
    }

    public function updateProgram($request, $key)
    {
        return $this->programRepository->update($request, $key); 
    }

    public function getUniversities() 
    {
        return $this->universityRepository->model()->get();
    }
}
