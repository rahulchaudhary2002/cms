<?php

namespace App\Http\Controllers;

use App\Http\Requests\Semester\AssignSemesterRequest;
use App\Services\StudentSemesterService;
use Illuminate\Http\Request;

class StudentSemesterController extends Controller
{
    private StudentSemesterService $studentSemesterService;

    public function __construct(StudentSemesterService $studentSemesterService)
    {
        $this->studentSemesterService = $studentSemesterService;
    }
    
    public function create($user_key)
    {
        $user = $this->studentSemesterService->getUserByKey($user_key);

        if (!$user->hasRole('student')) {
            abort(404);
        }

        $semester = $this->studentSemesterService->getSemester($user->student);
        $session = $this->studentSemesterService->getActiveSession($user->student->academic_year_id, $semester);

        return view('modules.semester.assign', compact('user', 'semester', 'session'));
    }

    public function store(AssignSemesterRequest $request, $user_key)
    {
        if ($this->studentSemesterService->assignSemesters($request, $user_key)) {
            return redirect()->route('student.index')->with('success', 'Semester is assigned to ' . $request->name . '.');
        }
        return redirect()->route('student.index')->with('error', 'Semester is not assigned to ' . $request->name . '.');
    }
}
