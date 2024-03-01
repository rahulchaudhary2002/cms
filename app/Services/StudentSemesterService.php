<?php

namespace App\Services;

use App\Interfaces\SemesterRepositoryInterFace;
use App\Interfaces\SessionRepositoryInterface;
use App\Interfaces\StudentCourseRepositoryInterface;
use App\Interfaces\StudentRepositoryInterface;
use App\Interfaces\StudentSemesterRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class StudentSemesterService
{
    private StudentSemesterRepositoryInterface $studentSemesterRepository;
    private StudentRepositoryInterface $studentRepository;
    private SemesterRepositoryInterFace $semesterRepository;
    private SessionRepositoryInterface $sessionRepository;
    private StudentCourseRepositoryInterface $studentCourseRepository;

    public function __construct(StudentSemesterRepositoryInterface $studentSemesterRepository, StudentRepositoryInterface $studentRepository, SemesterRepositoryInterFace $semesterRepository, SessionRepositoryInterface $sessionRepository, StudentCourseRepositoryInterface $studentCourseRepository)
    {
        $this->studentSemesterRepository = $studentSemesterRepository;
        $this->studentRepository = $studentRepository;
        $this->semesterRepository = $semesterRepository;
        $this->sessionRepository = $sessionRepository;
        $this->studentCourseRepository = $studentCourseRepository;
    }

    public function getSemesterById($id)
    {
        return $this->semesterRepository->getById($id);
    }

    public function getSemester($student)
    {
        if($student->semester) {
            $current = $this->semesterRepository->getById($student->semester->semester_id);
            
            return $this->semesterRepository->getByProgramAndOrder($student->program_id, $current->order + 1);
        }

        return $this->semesterRepository->getByProgramAndOrder($student->program_id, 1);
    }

    public function getUserByKey($user_key)
    {
        return $this->studentRepository->getByKey($user_key);
    }

    public function assignSemesters($request, $user_key)
    {
        $user = $this->getUserByKey($user_key);
        $semester = $this->getSemesterById($request->semester);

        try {
            DB::transaction(function () use ($request, $user, $semester) {
                $this->studentSemesterRepository->assign($request, $user->student->id);
                $this->studentCourseRepository->assign($request, $semester, $user->student->id);
            });

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getActiveSession($academicYear, $semester)
    {
        return $this->sessionRepository->getByActive($academicYear, $semester->id);
    }
}
