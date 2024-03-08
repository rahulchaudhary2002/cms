<?php

namespace App\Services;

use App\Interfaces\AcademicYearRepositoryInterface;
use App\Interfaces\ProgramRepositoryInterFace;
use App\Interfaces\SemesterRepositoryInterFace;
use App\Interfaces\SessionRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Jobs\SessionCreatedJob;
use App\Traits\AcademicYearTrait;
use App\Traits\ProgramTrait;
use App\Traits\SemesterTrait;
use Exception;

class SessionService
{
    use AcademicYearTrait, ProgramTrait, SemesterTrait;

    private SessionRepositoryInterFace $sessionRepository;
    private AcademicYearRepositoryInterface $academicYearRepository;
    private ProgramRepositoryInterFace $programRepository;
    private SemesterRepositoryInterFace $semesterRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(SessionRepositoryInterface $sessionRepository, AcademicYearRepositoryInterface $academicYearRepository, ProgramRepositoryInterFace $programRepository, SemesterRepositoryInterFace $semesterRepository, UserRepositoryInterface $userRepository)
    {
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
        $session = $this->sessionRepository->create($request);
        $users = $this->userRepository->model()->whereHas('student', function ($query) use ($request) {
            $query->where('academic_year_id', $request->academic_year)
                ->where('program_id', $request->program);
        })->get();

        dispatch(new SessionCreatedJob($users));

        return $session;
    }

    public function updateSession($request, $key)
    {
        return $this->sessionRepository->update($request, $key);
    }
}
