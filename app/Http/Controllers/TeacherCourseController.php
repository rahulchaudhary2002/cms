<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\AssignCourseRequest;
use App\Services\TeacherCourseService;

class TeacherCourseController extends Controller
{
    private TeacherCourseService $teacherCourseService;

    public function __construct(TeacherCourseService $teacherCourseService)
    {
        $this->teacherCourseService = $teacherCourseService;
    }

    public function create($user_key)
    {
        $user = $this->teacherCourseService->getTeacherByKey($user_key);
        $academicYears = $this->teacherCourseService->getAcademicYearWithSessions();    
        $sessions = $this->teacherCourseService->getSessionsWithAcademicYearSemesterAndProgram();
        $courses = $this->teacherCourseService->getCourses();
        $programs = $this->teacherCourseService->getPrograms();

        if(!$user->teacher) {
            abort(404);
        }

        return view('modules.course.assign', compact('user', 'academicYears', 'sessions', 'courses', 'programs'));
    }

    public function store(AssignCourseRequest $request, $user_key)
    {
        if($this->teacherCourseService->assignCourse($request, $user_key)) {
            return redirect()->route('user.index')->with('success', 'Course is assigned to ' . $request->name . '.');
        }
        return redirect()->route('user.index')->with('error', 'Course is not assigned to ' . $request->name . '.');
    }

    public function view($user_key)
    {
        $user = $this->teacherCourseService->getTeacherByKey($user_key);
        
        if(!$user->teacher) {
            abort(404);
        }

        return view('modules.curriculum.course.view', compact('user'));
    }
}
