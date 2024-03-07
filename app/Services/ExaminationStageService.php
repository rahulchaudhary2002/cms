<?php

namespace App\Services;

use App\Interfaces\AcademicYearRepositoryInterface;
use App\Interfaces\ExaminationStageRepositoryInterface;
use App\Interfaces\ProgramRepositoryInterFace;
use App\Interfaces\SemesterRepositoryInterFace;
use App\Interfaces\SessionRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Traits\AcademicYearTrait;
use App\Traits\ProgramTrait;
use App\Traits\SemesterTrait;
use App\Traits\SessionTrait;

class ExaminationStageService
{
    use AcademicYearTrait, ProgramTrait, SemesterTrait, SessionTrait;
    
    private ExaminationStageRepositoryInterface $examinationStageRepository;
    private ProgramRepositoryInterFace $programRepository;
    private SemesterRepositoryInterFace $semesterRepository;
    private AcademicYearRepositoryInterface $academicYearRepository;
    private SessionRepositoryInterface $sessionRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(ExaminationStageRepositoryInterface $examinationStageRepository, ProgramRepositoryInterFace $programRepository, SemesterRepositoryInterFace $semesterRepository, AcademicYearRepositoryInterface $academicYearRepository, SessionRepositoryInterface $sessionRepository, UserRepositoryInterface $userRepository)
    {
        $this->examinationStageRepository = $examinationStageRepository;
        $this->academicYearRepository = $academicYearRepository;
        $this->programRepository = $programRepository;
        $this->semesterRepository = $semesterRepository;
        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
    }

    public function getExaminationStages($request)
    {
        return $this->examinationStageRepository->get($request);
    }

    public function getExaminationStageByKey($key)
    {
        return $this->examinationStageRepository->getByKey($key);
    }

    public function createExaminationStage($request)
    {
        return $this->examinationStageRepository->create($request);
    }

    public function updateExaminationStage($request, $key)
    {
        return $this->examinationStageRepository->update($request, $key); 
    }
}
