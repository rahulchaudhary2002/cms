<?php

namespace App\Services;

use App\Interfaces\AcademicYearRepositoryInterface;
use App\Interfaces\CourseRepositoryInterFace;
use App\Interfaces\ExaminationMarkRepositoryInterface;
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
use Exception;
use Illuminate\Support\Facades\DB;

class ExaminationRecordService
{
    use AcademicYearTrait, ProgramTrait, SemesterTrait, SessionTrait, ExaminationStageTrait;

    private ExaminationRecordRepositoryInterface $examRecordRepository;
    private ExaminationMarkRepositoryInterface $examMarkRepository;
    private AcademicYearRepositoryInterface $academicYearRepository;
    private ProgramRepositoryInterFace $programRepository;
    private SemesterRepositoryInterFace $semesterRepository;
    private SessionRepositoryInterface $sessionRepository;
    private ExaminationStageRepositoryInterface $examinationStageRepository;
    private UserRepositoryInterface $userRepository;
    private StudentRepositoryInterface $studentRepository;
    private CourseRepositoryInterFace $courseRepository;

    public function __construct(ExaminationRecordRepositoryInterface $examRecordRepository, ExaminationMarkRepositoryInterface $examMarkRepository, AcademicYearRepositoryInterface $academicYearRepository, ProgramRepositoryInterFace $programRepository, SemesterRepositoryInterFace $semesterRepository, SessionRepositoryInterface $sessionRepository, ExaminationStageRepositoryInterface $examinationStageRepository, UserRepositoryInterface $userRepository, StudentRepositoryInterface $studentRepository, CourseRepositoryInterFace $courseRepository)
    {
        $this->examRecordRepository = $examRecordRepository;
        $this->examMarkRepository = $examMarkRepository;
        $this->academicYearRepository = $academicYearRepository;
        $this->programRepository = $programRepository;
        $this->semesterRepository = $semesterRepository;
        $this->sessionRepository = $sessionRepository;
        $this->examinationStageRepository = $examinationStageRepository;
        $this->userRepository = $userRepository;
        $this->studentRepository = $studentRepository;
        $this->courseRepository = $courseRepository;
    }

    public function getExaminationRecords($request)
    {
        return $this->examRecordRepository->get($request);
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

    public function createExaminationRecord($request, $examinationStageKey, $studentKey)
    {
        try {
            $record = null;

            $examinationStage = $this->getExaminationStageByKey($examinationStageKey);
            $user = $this->getUserByKey($studentKey);

            DB::transaction(function () use ($request, $examinationStage, $user, &$record) {
                $record = $this->examRecordRepository->create($request, $examinationStage->id, $user->student->id);
                $this->examMarkRepository->create($request, $record->id);
            });

            return $record;
        } catch (Exception $e) {
            return false;
        }
    }

    public function updateExaminationRecord($request, $examinationStageKey, $studentKey)
    {
        try {
            $record = null;

            $examinationStage = $this->getExaminationStageByKey($examinationStageKey);
            $user = $this->getUserByKey($studentKey);

            DB::transaction(function () use ($request, $examinationStage, $user, &$record) {
                $record = $this->examRecordRepository->update($request, $examinationStage->id, $user->student->id);
                $this->examMarkRepository->update($request, $record->id);
            });

            return $record;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getHeadings($request)
    {
        $headings = [
            'Student Id',
            'Student Name',
        ];

        $courses = $this->courseRepository->model()->whereHas('program', function ($query) use ($request) {
            return $query->where('key', $request->program);
        })->whereHas('semester', function ($query) use ($request) {
            return $query->where('key', $request->semester);
        })->get();

        foreach ($courses as $course) {
            array_push($headings, $course->course_code);
        }

        array_push($headings, 'GPA');

        return $headings;
    }
}
