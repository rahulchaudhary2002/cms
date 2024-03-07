<?php

namespace App\Services;

use App\Interfaces\AcademicYearRepositoryInterface;
use App\Interfaces\ExaminationStageRepositoryInterface;
use App\Interfaces\ProgramRepositoryInterFace;
use App\Interfaces\SemesterRepositoryInterFace;
use App\Interfaces\SessionRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;

class ExaminationStageService
{
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

    public function getAcademicYear()
    {
        return $this->academicYearRepository->model()->get();
    }

    public function getPrograms()
    {
        return $this->programRepository->model()->get();
    }

    public function getSemestersWithProgram()
    {
        $user = $this->userRepository->getById(auth()->user()->id);

        if($user->hasRole('student')) {
            return $this->semesterRepository->model()->with('program')->whereHas('studentSemesters', function ($query) use ($user) {
                $query->where('student_id', $user->student->id);
            })->get();
        }

        return $this->semesterRepository->getWithRelation('program');
    }

    public function getSessionsWithAcademicYearSemesterAndProgram()
    {
        $user = $this->userRepository->getById(auth()->user()->id);

        if ($user->hasRole('superadmin')) {
            return $this->sessionRepository->getWithRelation(['academicYear', 'semester', 'program']);
        }

        if ($user->hasRole('teacher')) {
            return $this->sessionRepository->model()->with(['academicYear', 'semester', 'program'])->whereHas('teacherCourses', function ($query) use ($user) {
                $query->where('teacher_id', $user->teacher->id);
            })->get();
        }

        if($user->hasRole('student')) {
            return [];
        }

        return $this->sessionRepository->getWithRelation(['academicYear', 'semester', 'program']);
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
