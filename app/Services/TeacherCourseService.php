<?php

namespace App\Services;

use App\Interfaces\AcademicYearRepositoryInterface;
use App\Interfaces\CourseRepositoryInterFace;
use App\Interfaces\ProgramRepositoryInterFace;
use App\Interfaces\SessionRepositoryInterface;
use App\Interfaces\TeacherCourseRepositoryInterface;
use App\Interfaces\TeacherRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Traits\AcademicYearTrait;
use App\Traits\CourseTrait;
use App\Traits\ProgramTrait;
use App\Traits\SessionTrait;

class TeacherCourseService
{
    use AcademicYearTrait, ProgramTrait, SessionTrait, CourseTrait;
    
    private UserRepositoryInterface $userRepository;
    private TeacherCourseRepositoryInterface $teacherCourseRepository;
    private TeacherRepositoryInterface $teacherRepository;
    private AcademicYearRepositoryInterface $academicYearRepository;
    private SessionRepositoryInterface $sessionRepository;
    private CourseRepositoryInterFace $courseRepository;
    private ProgramRepositoryInterFace $programRepository;

    public function __construct(UserRepositoryInterface $userRepository, TeacherCourseRepositoryInterface $teacherCourseRepository, TeacherRepositoryInterface $teacherRepository, AcademicYearRepositoryInterface $academicYearRepository, SessionRepositoryInterface $sessionRepository, CourseRepositoryInterFace $courseRepository, ProgramRepositoryInterFace $programRepository)
    {
        $this->userRepository = $userRepository;
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

    public function assignCourse($request, $user_key)
    {
        $user = $this->getTeacherByKey($user_key);

        return $this->teacherCourseRepository->assign($request, $user->teacher->id);
    }
}