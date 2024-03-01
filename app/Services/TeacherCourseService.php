<?php

namespace App\Services;

use App\Interfaces\AcademicYearRepositoryInterface;
use App\Interfaces\CourseRepositoryInterFace;
use App\Interfaces\ProgramRepositoryInterFace;
use App\Interfaces\SessionRepositoryInterface;
use App\Interfaces\TeacherCourseRepositoryInterface;
use App\Interfaces\TeacherRepositoryInterface;

class TeacherCourseService
{
    private TeacherCourseRepositoryInterface $teacherCourseRepository;
    private TeacherRepositoryInterface $teacherRepository;
    private AcademicYearRepositoryInterface $academicYearRepository;
    private SessionRepositoryInterface $sessionRepository;
    private CourseRepositoryInterFace $courseRepository;
    private ProgramRepositoryInterFace $programRepository;

    public function __construct(TeacherCourseRepositoryInterface $teacherCourseRepository, TeacherRepositoryInterface $teacherRepository, AcademicYearRepositoryInterface $academicYearRepository, SessionRepositoryInterface $sessionRepository, CourseRepositoryInterFace $courseRepository, ProgramRepositoryInterFace $programRepository) {
        $this->teacherCourseRepository = $teacherCourseRepository;
        $this->teacherRepository = $teacherRepository;
        $this->academicYearRepository = $academicYearRepository;
        $this->sessionRepository = $sessionRepository;
        $this->courseRepository = $courseRepository;
        $this->programRepository = $programRepository;
    }

    public function getTeacherByKey($user_key)
    {
        return $this->teacherRepository->getByKey($user_key);
    }

    public function getAcademicYearWithSessions()
    {
        return $this->academicYearRepository->getWithSessions();
    }

    public function getSessionsWithAcademicYearSemesterAndProgram()
    {
        return $this->sessionRepository->getWithRelation(['academicYear', 'semester', 'program']);
    }

    public function getCourses()
    {
        return $this->courseRepository->model()->get();
    }

    public function getPrograms()
    {
        return $this->programRepository->model()->get();
    }

    public function assignCourse($request, $user_key)
    {
        $user = $this->getTeacherByKey($user_key);

        return $this->teacherCourseRepository->assign($request, $user->teacher->id);
    }
}