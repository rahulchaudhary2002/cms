<?php

namespace App\Services;

use App\Interfaces\AcademicYearRepositoryInterface;
use App\Interfaces\ProgramRepositoryInterFace;
use App\Interfaces\SemesterRepositoryInterFace;
use App\Interfaces\SessionRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Traits\AcademicYearTrait;
use App\Traits\ProgramTrait;
use App\Traits\SemesterTrait;

class SessionService
{
    use AcademicYearTrait, ProgramTrait, SemesterTrait;

    private SessionRepositoryInterFace $sessionRepository;
    private AcademicYearRepositoryInterface $academicYearRepository;
    private ProgramRepositoryInterFace $programRepository;
    private SemesterRepositoryInterFace $semesterRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(SessionRepositoryInterface $sessionRepository, AcademicYearRepositoryInterface $academicYearRepository, ProgramRepositoryInterFace $programRepository, SemesterRepositoryInterFace $semesterRepository, UserRepositoryInterface $userRepository) {
        $this->sessionRepository = $sessionRepository;
        $this->academicYearRepository = $academicYearRepository;
        $this->programRepository = $programRepository;
        $this->semesterRepository = $semesterRepository;
        $this->userRepository = $userRepository;
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
}