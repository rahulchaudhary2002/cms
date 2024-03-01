<?php

namespace App\Services;

use App\Interfaces\AcademicYearRepositoryInterface;
use App\Interfaces\CourseRepositoryInterFace;
use App\Interfaces\ProgramRepositoryInterFace;
use App\Interfaces\SemesterRepositoryInterFace;
use App\Interfaces\SessionRepositoryInterface;
use App\Interfaces\StudentAttendanceRepositoryInterface;
use App\Interfaces\StudentRepositoryInterface;
use Exception;

class StudentAttendanceService
{
    private StudentAttendanceRepositoryInterface $studentAttendanceRepository;
    private StudentRepositoryInterface $studentRepository;
    private ProgramRepositoryInterFace $programRepository;
    private SemesterRepositoryInterFace $semesterRepository;
    private AcademicYearRepositoryInterface $academicYearRepository;
    private SessionRepositoryInterface $sessionRepository;
    private CourseRepositoryInterFace $courseRepository;

    public function __construct(StudentAttendanceRepositoryInterface $studentAttendanceRepository, StudentRepositoryInterface $studentRepository, ProgramRepositoryInterFace $programRepository, SemesterRepositoryInterFace $semesterRepository, AcademicYearRepositoryInterface $academicYearRepository, SessionRepositoryInterface $sessionRepository, CourseRepositoryInterface $courseRepository)
    {
        $this->studentAttendanceRepository = $studentAttendanceRepository;
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

    public function getPrograms()
    {
        return $this->programRepository->model()->get();
    }

    public function getAcademicYear()
    {
        return $this->academicYearRepository->model()->get();
    }

    public function getSemestersWithProgram()
    {
        $user = $this->studentRepository->getById(auth()->user()->id);

        if ($user->hasRole('student')) {
            return $this->semesterRepository->model()->with('program')->whereHas('studentSemesters', function ($query) use ($user) {
                $query->where('student_id', $user->student->id);
            })->get();
        }

        return $this->semesterRepository->getWithRelation('program');
    }

    public function getSessionsWithAcademicYearSemesterAndProgram()
    {
        $user = $this->studentRepository->getById(auth()->user()->id);

        if ($user->hasRole('superadmin')) {
            return $this->sessionRepository->getWithRelation(['academicYear', 'semester', 'program']);
        }

        if ($user->hasRole('teacher')) {
            return $this->sessionRepository->model()->with(['academicYear', 'semester', 'program'])->whereHas('teacherCourses', function ($query) use ($user) {
                $query->where('teacher_id', $user->teacher->id);
            })->get();
        }

        if ($user->hasRole('student')) {
            return [];
        }

        return $this->sessionRepository->getWithRelation(['academicYear', 'semester', 'program']);
    }

    public function getCoursesWithSemester()
    {
        $user = $this->studentRepository->getById(auth()->user()->id);

        if ($user->hasRole('superadmin')) {
            return $this->courseRepository->getWithRelation(['semester']);
        }

        if ($user->hasRole('teacher')) {
            return $this->courseRepository->model()->with(['semester', 'teacherCourses.session'])->whereHas('teacherCourses', function ($query) use ($user) {
                $query->where('teacher_id', $user->teacher->id);
            })->get();
        }

        if ($user->hasRole('student')) {
            return $this->courseRepository->model()->with(['semester'])->whereHas('studentCourses', function ($query) use ($user) {
                $query->where('student_id', $user->student->id);
            })->get();
        }

        return $this->courseRepository->getWithRelation(['semester']);
    }

    public function takeAttendance($request)
    {
        return $this->studentAttendanceRepository->create($request);
    }
}
