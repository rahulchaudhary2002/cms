<?php

namespace App\Services;

use App\Interfaces\AcademicYearRepositoryInterface;
use App\Interfaces\CourseRepositoryInterFace;
use App\Interfaces\ProgramRepositoryInterFace;
use App\Interfaces\SemesterRepositoryInterFace;
use App\Interfaces\SessionRepositoryInterface;
use App\Interfaces\StudentAttendanceRepositoryInterface;
use App\Interfaces\StudentRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Traits\AcademicYearTrait;
use App\Traits\CourseTrait;
use App\Traits\ProgramTrait;
use App\Traits\SemesterTrait;
use App\Traits\SessionTrait;
use Exception;

class StudentAttendanceService
{
    use AcademicYearTrait, ProgramTrait, SemesterTrait, SessionTrait, CourseTrait;

    private StudentAttendanceRepositoryInterface $studentAttendanceRepository;
    private UserRepositoryInterface $userRepository;
    private StudentRepositoryInterface $studentRepository;
    private ProgramRepositoryInterFace $programRepository;
    private SemesterRepositoryInterFace $semesterRepository;
    private AcademicYearRepositoryInterface $academicYearRepository;
    private SessionRepositoryInterface $sessionRepository;
    private CourseRepositoryInterFace $courseRepository;

    public function __construct(StudentAttendanceRepositoryInterface $studentAttendanceRepository, UserRepositoryInterface $userRepository, StudentRepositoryInterface $studentRepository, ProgramRepositoryInterFace $programRepository, SemesterRepositoryInterFace $semesterRepository, AcademicYearRepositoryInterface $academicYearRepository, SessionRepositoryInterface $sessionRepository, CourseRepositoryInterface $courseRepository)
    {
        $this->studentAttendanceRepository = $studentAttendanceRepository;
        $this->userRepository = $userRepository;
        $this->studentRepository = $studentRepository;
        $this->programRepository = $programRepository;
        $this->semesterRepository = $semesterRepository;
        $this->academicYearRepository = $academicYearRepository;
        $this->sessionRepository = $sessionRepository;
        $this->courseRepository = $courseRepository;
    }

    public function getStudents($request)
    {
        $request->merge(['perPage' => 100]);
        $program = $this->programRepository->getByKey($request->program);
        $course = $this->courseRepository->getByKey($request->course);
        $academicYear = $this->academicYearRepository->getByKey($request->academic_year);

        if ($request->user()->hasRole('student')) {
            $students = ['students' => $this->studentRepository->model()->where('id', $request->user()->id)->get()];
        } else {
            $students = $this->studentRepository->get($request);
        }

        if (is_array($students)) {
            $result = array_merge($students, ['course' => $course, 'program' => $program, 'academicYear' => $academicYear, 'date' => $request->date]);
        } else {
            $result = $students->toArray();
            $result = array_merge($result, ['course' => $course, 'program' => $program, 'academicYear' => $academicYear, 'date' => $request->date]);
        }

        return $result;
    }

    public function getAttendances($request)
    {
        try {
            $course = $this->courseRepository->getByKey($request->course);
            $attendances = $this->studentAttendanceRepository->model()->setTable('student_attendances_' . date('Ym', strtotime($request->date)));
            $attendances = $attendances->where('course_id', $course->id)->get();

            return $attendances;
        } catch (Exception $e) {
        }
    }

    public function takeAttendance($request)
    {
        return $this->studentAttendanceRepository->create($request);
    }
}
