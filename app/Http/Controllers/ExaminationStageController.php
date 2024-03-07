<?php

namespace App\Http\Controllers;

use App\Http\Requests\Examination\CreateExaminationStageRequest;
use App\Http\Requests\Examination\UpdateExaminationStageRequest;
use App\Services\ExaminationStageService;
use Illuminate\Http\Request;

class ExaminationStageController extends Controller
{
    private ExaminationStageService $examinationStageService;

    public function __construct(ExaminationStageService $examinationStageService)
    {
        $this->examinationStageService = $examinationStageService;
    }

    public function index(Request $request)
    {
        $result = (object) $this->examinationStageService->getExaminationStages($request);
        $academicYears = $this->examinationStageService->getAcademicYears();
        $programs = $this->examinationStageService->getPrograms();
        $semesters = $this->examinationStageService->getSemestersWithProgram();
        $sessions = $this->examinationStageService->getSessionsWithAcademicYearSemesterAndProgram();
        
        return view('modules.examination.stage.index', compact('result', 'academicYears', 'programs', 'semesters', 'sessions'));
    }

    public function create()
    {
        $academicYears = $this->examinationStageService->getAcademicYears();
        $programs = $this->examinationStageService->getPrograms();
        $semesters = $this->examinationStageService->getSemestersWithProgram();
        $sessions = $this->examinationStageService->getSessionsWithAcademicYearSemesterAndProgram();
        
        return view('modules.examination.stage.create', compact('academicYears', 'programs', 'semesters', 'sessions'));
    }

    public function store(CreateExaminationStageRequest $request)
    {
        if($this->examinationStageService->createExaminationStage($request)) {
            return redirect()->route('examination.stage.index')->with('success', 'Examination stage is created!');
        }
        return redirect()->route('examination.stage.index')->with('error', 'Examination stage is not created!');
    }

    public function edit($key)
    {
        $examinationStage = $this->examinationStageService->getExaminationStageByKey($key);
        $academicYears = $this->examinationStageService->getAcademicYears();
        $programs = $this->examinationStageService->getPrograms();
        $semesters = $this->examinationStageService->getSemestersWithProgram();
        $sessions = $this->examinationStageService->getSessionsWithAcademicYearSemesterAndProgram();
        
        return view('modules.examination.stage.edit', compact('examinationStage', 'academicYears', 'programs', 'semesters', 'sessions'));
    }

    public function update(UpdateExaminationStageRequest $request, $key)
    {
        if($this->examinationStageService->updateExaminationStage($request, $key)) {
            return redirect()->route('examination.stage.index')->with('success', 'Examination stage is updated!');
        }
        return redirect()->route('examination.stage.index')->with('error', 'Examination stage is not updated!');
    }
}
