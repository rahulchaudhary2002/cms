<?php

namespace App\Services;

use App\Interfaces\AcademicYearRepositoryInterface;
use App\Interfaces\ProgramRepositoryInterFace;
use App\Interfaces\SemesterRepositoryInterFace;
use App\Interfaces\SessionRepositoryInterface;

class SessionService
{
    private SessionRepositoryInterFace $sessionRepository;
    private AcademicYearRepositoryInterface $academicYearRepository;
    private ProgramRepositoryInterFace $programRepository;
    private SemesterRepositoryInterFace $semesterRepository;

    public function __construct(SessionRepositoryInterface $sessionRepository, AcademicYearRepositoryInterface $academicYearRepository, ProgramRepositoryInterFace $programRepository, SemesterRepositoryInterFace $semesterRepository) {
        $this->sessionRepository = $sessionRepository;
        $this->academicYearRepository = $academicYearRepository;
        $this->programRepository = $programRepository;
        $this->semesterRepository = $semesterRepository;
    }

    public function getSessions($request)
    {
        return $this->sessionRepository->get($request);
    }

    public function getSessionByKey($key)
    {
        return $this->sessionRepository->getByKey($key);
    }

    public function createSession($request)
    {
        return $this->sessionRepository->create($request);
    }

    public function updateSession($request, $key)
    {
        return $this->sessionRepository->update($request, $key); 
    }

    public function getAcademicYears()
    {
        return $this->academicYearRepository->model()->get(); 
    }

    public function getPrograms()
    {
        return $this->programRepository->model()->get(); 
    }

    public function getSemesters()
    {
        return $this->semesterRepository->model()->get(); 
    }

    public function getSemestersWithProgram() 
    {
        return $this->semesterRepository->getWithRelation('program');
    }
}