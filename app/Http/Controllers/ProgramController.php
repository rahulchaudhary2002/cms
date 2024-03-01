<?php

namespace App\Http\Controllers;

use App\Http\Requests\Program\CreateProgramRequest;
use App\Http\Requests\Program\UpdateProgramRequest;
use App\Services\ProgramService;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    private ProgramService $programService;

    public function __construct(ProgramService $programService)
    {
        $this->programService = $programService;
    }

    public function index(Request $request)
    {
        $result = (object) $this->programService->getPrograms($request);
        return view('modules.program.index', compact('result'));        
    }

    public function create()
    {
        $universities = $this->programService->getUniversities();
        return view('modules.program.create', compact('universities'));
    }

    public function store(CreateProgramRequest $request)
    {
        if($this->programService->createProgram($request)) {
            return redirect()->route('program.index')->with('success', 'Program is created.');
        }
        return redirect()->route('program.index')->with('error', 'Program is not created.');
    }

    public function edit($key)
    {
        $program = $this->programService->getProgramByKey($key);
        $universities = $this->programService->getUniversities();
        return view('modules.program.edit', compact('program', 'universities'));
    }

    public function update(UpdateProgramRequest $request, $key)
    {
        if($this->programService->updateProgram($request, $key)) {
            return redirect()->route('program.index')->with('success', 'Program is updated.');
        }
        return redirect()->route('program.index')->with('error', 'Program is not updated.');
    }
}
