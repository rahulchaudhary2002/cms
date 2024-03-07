<?php

namespace App\Http\Controllers;

use App\Http\Requests\Attendance\Student\TakeAttendanceRequest;
use App\Services\StudentAttendanceService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentAttendanceController extends Controller
{
    private StudentAttendanceService $studentAttendanceService;

    public function __construct(StudentAttendanceService $studentAttendanceService)
    {
        $this->studentAttendanceService = $studentAttendanceService;
    }

    public function index(Request $request)
    {
        $result = [];
        $days = 0;
        $attendances = [];
        
        if($request->academic_year && $request->program && $request->semester && $request->course && $request->date) {
            $attendances = $this->studentAttendanceService->getAttendances($request);
            $days = Carbon::createFromFormat('Y-m', $request->date)->daysInMonth;
            $result = (object) $this->studentAttendanceService->getStudents($request);
        }

        $programs = $this->studentAttendanceService->getPrograms();
        $semesters = $this->studentAttendanceService->getSemestersWithProgram();
        $academicYears = $this->studentAttendanceService->getAcademicYears();
        $sessions = $this->studentAttendanceService->getSessionsWithAcademicYearSemesterAndProgram();
        $courses = $this->studentAttendanceService->getCoursesWithSemester();

        return view('modules.attendance.student.index', compact('result', 'programs', 'semesters', 'academicYears', 'sessions', 'courses', 'days', 'attendances'));
    }

    public function take(Request $request)
    {
        $result = [];

        if($request->academic_year && $request->program && $request->semester && $request->session && $request->course && $request->date) {
            $result = (object) $this->studentAttendanceService->getStudents($request);
        }
        $programs = $this->studentAttendanceService->getPrograms();
        $semesters = $this->studentAttendanceService->getSemestersWithProgram();
        $academicYears = $this->studentAttendanceService->getAcademicYears();
        $sessions = $this->studentAttendanceService->getSessionsWithAcademicYearSemesterAndProgram();
        $courses = $this->studentAttendanceService->getCoursesWithSemester();

        return view('modules.attendance.student.take', compact('result', 'programs', 'semesters', 'academicYears', 'sessions', 'courses'));
    }

    public function store(TakeAttendanceRequest $request)
    {
        if($this->studentAttendanceService->takeAttendance($request)) {
            return redirect()->route('student.attendance.index')->with('success', 'Attendance is taken.');
        }

        return redirect()->route('student.attendance.index')->with('error', 'Attendance is not taken.');
    }
}
