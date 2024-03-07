<?php

namespace App\Services;

use App\Interfaces\CourseRepositoryInterFace;
use App\Interfaces\ProgramRepositoryInterFace;
use App\Interfaces\SemesterRepositoryInterFace;
use App\Interfaces\UserRepositoryInterface;
use App\Traits\ProgramTrait;
use App\Traits\SemesterTrait;

class CourseService
{
    use ProgramTrait, SemesterTrait;

    private ProgramRepositoryInterFace $programRepository;
    private SemesterRepositoryInterFace $semesterRepository;
    private CourseRepositoryInterFace $courseRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(ProgramRepositoryInterFace $programRepository, CourseRepositoryInterface $courseRepository, SemesterRepositoryInterFace $semesterRepository, UserRepositoryInterface $userRepository) {
        $this->programRepository = $programRepository;
        $this->courseRepository = $courseRepository;
        $this->semesterRepository = $semesterRepository;
        $this->userRepository = $userRepository;
    }

    public function getCourses($request)
    {
        return $this->courseRepository->get($request);
    }

    public function getCourseByKey($key)
    {
        return $this->courseRepository->getByKey($key);
    }

    public function createCourse($request)
    {
        return $this->courseRepository->create($request);
    }

    public function updateCourse($request, $key)
    {
        return $this->courseRepository->update($request, $key); 
    }
}
