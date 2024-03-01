<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\CreateCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Services\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    private CourseService $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index(Request $request)
    {
        $result = (object) $this->courseService->getCourses($request);
        $programs = $this->courseService->getPrograms();
        $semesters = $this->courseService->getSemestersWithProgram();
        
        return view('modules.course.index', compact('result', 'programs', 'semesters'));       
    }

    public function create()
    {
        $programs = $this->courseService->getPrograms();
        $semesters = $this->courseService->getSemesters();
        
        return view('modules.course.create', compact('programs', 'semesters'));
    }

    public function store(CreateCourseRequest $request)
    {
        if($this->courseService->createCourse($request)) {
            return redirect()->route('course.index')->with('success', 'Course is created.');
        }
        return redirect()->route('course.index')->with('error', 'Course is not created.');
    }

    public function edit($key)
    {
        $programs = $this->courseService->getPrograms();
        $semesters = $this->courseService->getSemesters();
        $course = $this->courseService->getCourseByKey($key);

        return view('modules.course.edit', compact('programs', 'semesters', 'course'));
    }

    public function update(UpdateCourseRequest $request, $key)
    {
        if($this->courseService->updateCourse($request, $key)) {
            return redirect()->route('course.index')->with('success', 'Course is updated.');
        }
        return redirect()->route('course.index')->with('error', 'Course is not updated.');
    }
}
