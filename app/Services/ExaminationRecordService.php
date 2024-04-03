<?php

namespace App\Services;

use App\Interfaces\AcademicYearRepositoryInterface;
use App\Interfaces\ExaminationRecordRepositoryInterface;
use App\Interfaces\ExaminationStageRepositoryInterface;
use App\Interfaces\ProgramRepositoryInterFace;
use App\Interfaces\SemesterRepositoryInterFace;
use App\Interfaces\SessionRepositoryInterface;
use App\Interfaces\StudentRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Traits\AcademicYearTrait;
use App\Traits\ExaminationStageTrait;
use App\Traits\ProgramTrait;
use App\Traits\SemesterTrait;
use App\Traits\SessionTrait;

class ExaminationRecordService
{
    use AcademicYearTrait, ProgramTrait, SemesterTrait, SessionTrait, ExaminationStageTrait;
    
    private ExaminationRecordRepositoryInterface $examRecordRepository;
    private AcademicYearRepositoryInterface $academicYearRepository;
    private ProgramRepositoryInterFace $programRepository;
    private SemesterRepositoryInterFace $semesterRepository;
    private SessionRepositoryInterface $sessionRepository;
    private ExaminationStageRepositoryInterface $examinationStageRepository;
    private UserRepositoryInterface $userRepository;
    private StudentRepositoryInterface $studentRepository;

    public function __construct(ExaminationRecordRepositoryInterface $examRecordRepository, AcademicYearRepositoryInterface $academicYearRepository, ProgramRepositoryInterFace $programRepository, SemesterRepositoryInterFace $semesterRepository, SessionRepositoryInterface $sessionRepository, ExaminationStageRepositoryInterface $examinationStageRepository, UserRepositoryInterface $userRepository, StudentRepositoryInterface $studentRepository)
    {
        $this->examRecordRepository = $examRecordRepository;
        $this->academicYearRepository = $academicYearRepository;
        $this->programRepository = $programRepository;
        $this->semesterRepository = $semesterRepository;
        $this->sessionRepository = $sessionRepository;
        $this->examinationStageRepository = $examinationStageRepository;
        $this->userRepository = $userRepository;
        $this->studentRepository = $studentRepository;
    }

    public function getStudents($request)
    {
        return $this->studentRepository->get($request);
    }

    public function getUserByKey($key)
    {
        return $this->userRepository->getByKey($key);
    }

    public function getExaminationStageByKey($key)
    {
        return $this->examinationStageRepository->getByKey($key);
    }
}
