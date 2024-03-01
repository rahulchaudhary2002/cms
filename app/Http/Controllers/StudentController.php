<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\CreateStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use App\Services\StudentService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    private StudentService $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function index(Request $request)
    {
        $result = (object) $this->studentService->getStudents($request);
        $academicYears = $this->studentService->getAcademicYears();
        $programs = $this->studentService->getPrograms();
        $semesters = $this->studentService->getSemestersWithProgram();
        $sessions = $this->studentService->getSessionsWithAcademicYearAndSemester();

        return view('modules.student.index', compact('result', 'academicYears', 'programs', 'semesters', 'sessions'));        
    }

    public function create(Request $request)
    {
        $role = $this->studentService->getRoleByKey('student');
        $permissionsViaRole = $this->studentService->getPermissionsViaRole($role)->pluck('id')->toArray();
        $permissions = $this->studentService->getPermissions();
        $permissionsGroups = $permissions->groupBy('type');
        $academicYears = $this->studentService->getAcademicYears();
        $programs = $this->studentService->getPrograms();

        return view('modules.student.create', compact('role', 'permissionsViaRole', 'permissions', 'permissionsGroups', 'academicYears', 'programs'));
    }

    public function store(CreateStudentRequest $request)
    {
        if($this->studentService->createStudent($request)) {
            return redirect()->route('student.index')->with('success', 'Student is created.');
        }

        return redirect()->route('student.index')->with('error', 'Student is not created.');
    }

    public function edit(Request $request, $key)
    {
        $student = $this->studentService->getStudentByKey($key);
        $role = $this->studentService->getRoleByKey('student');
        $permissions = $this->studentService->getPermissions();
        $permissionsGroups = $permissions->groupBy('type');
        $academicYears = $this->studentService->getAcademicYears();
        $programs = $this->studentService->getPrograms();
        
        if(!$student->hasRole('student')) {
            abort(404);
        }

        return view('modules.student.edit', compact('student', 'role', 'permissions', 'permissionsGroups', 'academicYears', 'programs'));
    }

    public function update(UpdateStudentRequest $request, $key)
    {
        if($this->studentService->updateStudent($request, $key)) {
            return redirect()->route('student.index')->with('success', 'Student is updated.');
        }

        return redirect()->route('student.index')->with('error', 'Student is not updated.');
    }

    public function show($key)
    {
        $user = $this->studentService->getStudentByKey($key);
        
        if(!$user->student) {
            abort(404);
        }

        return view('modules.student.show', compact('user'));        
    }
}
