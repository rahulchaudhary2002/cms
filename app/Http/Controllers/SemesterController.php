<?php

namespace App\Http\Controllers;

use App\Http\Requests\Semester\CreateSemesterRequest;
use App\Http\Requests\Semester\UpdateSemesterRequest;
use App\Services\SemesterService;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    private SemesterService $semesterService;

    public function __construct(SemesterService $semesterService)
    {
        $this->semesterService = $semesterService;
    }

    public function index(Request $request)
    {
        $result = (object) $this->semesterService->getSemesters($request);
        $programs = $this->semesterService->getPrograms();

        return view('modules.semester.index', compact('result', 'programs'));        
    }

    public function create()
    {
        $programs = $this->semesterService->getPrograms();

        return view('modules.semester.create', compact('programs'));
    }

    public function store(CreateSemesterRequest $request)
    {
        if($this->semesterService->createSemester($request)) {
            return redirect()->route('semester.index')->with('success', 'Semester is created.');
        }
        return redirect()->route('semester.index')->with('error', 'Semester is not created.');
    }

    public function edit($key)
    {
        $semester = $this->semesterService->getSemesterByKey($key);
        $programs = $this->semesterService->getPrograms();

        return view('modules.semester.edit', compact('semester', 'programs'));
    }

    public function update(UpdateSemesterRequest $request, $key)
    {
        if($this->semesterService->updateSemester($request, $key)) {
            return redirect()->route('semester.index')->with('success', 'Semester is updated.');
        }
        return redirect()->route('semester.index')->with('error', 'Semester is not updated.');
    }
}
