<?php

namespace App\Services;

use App\Interfaces\ProgramRepositoryInterFace;
use App\Interfaces\SemesterRepositoryInterFace;
use App\Traits\ProgramTrait;

class SemesterService
{
    use ProgramTrait;
    
    private SemesterRepositoryInterFace $semesterRepository;
    private ProgramRepositoryInterFace $programRepository;

    public function __construct(SemesterRepositoryInterface $semesterRepository, ProgramRepositoryInterFace $programRepository) {
        $this->semesterRepository = $semesterRepository;
        $this->programRepository = $programRepository;
    }

    public function getSemesters($request)
    {
        return $this->semesterRepository->get($request);
    }

    public function getSemesterByKey($key)
    {
        return $this->semesterRepository->getByKey($key);
    }

    public function createSemester($request)
    {
        return $this->semesterRepository->create($request);
    }

    public function updateSemester($request, $key)
    {
        return $this->semesterRepository->update($request, $key); 
    }
}
