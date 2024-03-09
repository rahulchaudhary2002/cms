<?php

namespace App\Http\Controllers;

use App\Http\Requests\Assignment\AssignmentSubmissionRequest;
use App\Http\Requests\Assignment\CheckAssignmentRequest;
use App\Http\Requests\Assignment\CreateAssignmentRequest;
use App\Http\Requests\Assignment\UpdateAssignmentRequest;
use App\Services\AssignmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    private AssignmentService $assignmentService;

    public function __construct(AssignmentService $assignmentService)
    {
        $this->assignmentService = $assignmentService;
    }

    public function index(Request $request)
    {
        $result = (object) $this->assignmentService->getAssignments($request);
        $academicYears = $this->assignmentService->getAcademicYears();
        $programs = $this->assignmentService->getPrograms();
        $semesters = $this->assignmentService->getSemestersWithProgram();
        $sessions = $this->assignmentService->getSessionsWithAcademicYearSemesterAndProgram();
        $courses = $this->assignmentService->getCoursesWithSemester();

        return view('modules.assignment.index', compact('result', 'academicYears', 'programs', 'semesters', 'sessions', 'courses'));
    }

    public function create()
    {
        $academicYears = $this->assignmentService->getAcademicYears();
        $programs = $this->assignmentService->getPrograms();
        $semesters = $this->assignmentService->getSemestersWithProgram();
        $sessions = $this->assignmentService->getSessionsWithAcademicYearSemesterAndProgram();
        $courses = $this->assignmentService->getCoursesWithSemester();

        return view('modules.assignment.create', compact('academicYears', 'programs', 'semesters', 'sessions', 'courses'));
    }

    public function store(CreateAssignmentRequest $request)
    {
        if($this->assignmentService->createAssignment($request)) {
            return redirect()->route('assignment.index')->with('success', 'Assignment is created!');
        }
        return redirect()->route('assignment.index')->with('error', 'Assignment is not created!');
    }

    public function edit($key)
    {
        $assignment = $this->assignmentService->getAssignmentByKey($key);
        
        if($assignment->submissions()->count() > 0) {
            abort(404);
        }
        
        $academicYears = $this->assignmentService->getAcademicYears();
        $programs = $this->assignmentService->getPrograms();
        $semesters = $this->assignmentService->getSemestersWithProgram();
        $sessions = $this->assignmentService->getSessionsWithAcademicYearSemesterAndProgram();
        $courses = $this->assignmentService->getCoursesWithSemester();

        return view('modules.assignment.edit', compact('assignment', 'academicYears', 'programs', 'semesters', 'sessions', 'courses'));
    }

    public function update(UpdateAssignmentRequest $request, $key)
    {
        $assignment = $this->assignmentService->getAssignmentByKey($key);
        
        if($assignment->submissions()->count() > 0) {
            abort(404);
        }
        
        if($this->assignmentService->updateAssignment($request, $key)) {
            return redirect()->route('assignment.index')->with('success', 'Assignment is updated!');
        }
        return redirect()->route('assignment.index')->with('error', 'Assignment is not updated!');
    }

    public function show($key)
    {
        $assignment = $this->assignmentService->getAssignmentByKey($key);

        return view('modules.assignment.show', compact('assignment'));
    }

    public function submissions($key)
    {
        $assignment = $this->assignmentService->getAssignmentByKey($key);

        return view('modules.assignment.submission.index', compact('assignment'));
    }

    public function createSubmission($key)
    {
        if(!auth()->user()->student) {
            abort(404);
        }

        $assignment = $this->assignmentService->getAssignmentByKey($key);
        
        if($assignment->authSubmission) {
            return redirect()->route('assignment.submission.show', ['key' => $key, 'student_key' => auth()->user()->key]);
        }

        if($assignment->submission_date < now()->format('Y-m-d') && $assignment->late_submission == 0 && !$assignment->authSubmission) {
            abort('419');
        }
        
        return view('modules.assignment.submission.create', compact('assignment'));
    }

    public function storeSubmission(AssignmentSubmissionRequest $request, $key)
    {
        if($this->assignmentService->storeSubmission($request, $key)) {
            return redirect()->route('assignment.index')->with('success', 'Assignment is submitted!');
        }
        return redirect()->route('assignment.index')->with('error', 'Assignment is not submitted!');
    }

    public function showSubmission($key, $student_key)
    {
        $submission = $this->assignmentService->getAssignmentSubmission($key, $student_key);
        
        return view('modules.assignment.submission.show', compact('submission'));
    }

    public function check($key, $student_key)
    {
        $submission = $this->assignmentService->getAssignmentSubmission($key, $student_key);
        
        if($submission->checked == 1) {
            abort(404);
        }

        return view('modules.assignment.submission.check', compact('submission'));
    }

    public function checking(CheckAssignmentRequest $request, $key, $student_key)
    {
        if($this->assignmentService->checkSubmission($request, $key, $student_key)) {
            return redirect()->route('assignment.submission.index', $key)->with('success', 'Assignment is checked!');
        }
        return redirect()->route('assignment.submission.index', $key)->with('error', 'Assignment is not checked!');
    }

    public function uploadFile(Request $request)
    {
        ini_set('memory_limit', '256M');
        ini_set('upload_max_filesize', '24M');
        ini_set('post_max_size', '32M');

        if (!$request->ajax() || !$request->hasFile('file')) {
            return response()->json(['status' => 'failed'], 200);
        }

        if (strtolower($request->file('file')->getClientOriginalExtension()) == 'pdf') {
            $filename = 'file_' . time() . '.' . $request->file('file')->getClientOriginalExtension();
        }
        else {
            $filename = 'image_' . time() . '.' . $request->file('file')->getClientOriginalExtension();
        }

        if ($request->file('file')->storeAs('public/assignment', $filename)) {
            return response()->json(['status' => 'success', 'filename' => $filename], 200);
        }

        return response()->json(['status' => 'failed'], 200);
    }

    public function removeFile(Request $request)
    {
        if (!$request->ajax() || !$request->filled('file')) {
            return response()->json(['status' => 'failed'], 200);
        }

        if (!Storage::exists('public/assignment/' . $request->file)) {
            return response()->json(['status' => 'failed', 'issue' => ''], 200);
        }

        Storage::delete('public/assignment/' . $request->file);

        return response()->json(['status' => 'success'], 200);
    }
}
