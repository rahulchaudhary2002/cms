<?php

namespace App\Services;

use App\Interfaces\CourseRepositoryInterFace;
use App\Interfaces\ProgramRepositoryInterFace;
use App\Interfaces\SemesterRepositoryInterFace;

class CourseService
{
    private ProgramRepositoryInterFace $programRepository;
    private SemesterRepositoryInterFace $semesterRepository;
    private CourseRepositoryInterFace $courseRepository;

    public function __construct(ProgramRepositoryInterFace $programRepository, CourseRepositoryInterface $courseRepository, SemesterRepositoryInterFace $semesterRepository) {
        $this->programRepository = $programRepository;
        $this->courseRepository = $courseRepository;
        $this->semesterRepository = $semesterRepository;
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

    public function getSemesters() 
    {
        return $this->semesterRepository->model()->get();
    }

    public function getSemestersWithProgram() 
    {
        return $this->semesterRepository->getWithRelation('program');
    }

    public function getPrograms() 
    {
        return $this->programRepository->model()->get();
    }
}
