<?php

namespace App\Http\Controllers;

use App\Http\Requests\Examination\CreateExaminationRecordRequest;
use App\Services\ExaminationRecordService;
use Illuminate\Http\Request;

class ExaminationRecordController extends Controller
{
    private ExaminationRecordService $examinationRecordService;

    public function __construct(ExaminationRecordService $examinationRecordService)
    {
        $this->examinationRecordService = $examinationRecordService;
    }

    public function index(Request $request)
    {
        $result = [];
        
        if($request->academic_year && $request->program && $request->semester && $request->session && $request->examination_stage) {
            $result = (object) $this->examinationRecordService->getStudents($request);
        }

        $academicYears = $this->examinationRecordService->getAcademicYears();
        $programs = $this->examinationRecordService->getPrograms();
        $semesters = $this->examinationRecordService->getSemestersWithProgram();
        $sessions = $this->examinationRecordService->getSessionsWithAcademicYearSemesterAndProgram();
        $examinationStages = $this->examinationRecordService->getExaminationStagesWithAcademicYearProgramSemesterAndSession();

        return view('modules.examination.record.index', compact('result', 'academicYears', 'programs', 'semesters', 'sessions', 'examinationStages'));
    }

    public function create($examinationStageKey, $studentKey)
    {
        $examinationStage = $this->examinationRecordService->getExaminationStageByKey($examinationStageKey);
        $student = $this->examinationRecordService->getUserByKey($studentKey);
        
        return view('modules.examination.record.create', compact('examinationStage', 'student'));
    }

    public function store(CreateExaminationRecordRequest $request, $examinationStageKey, $studentKey)
    {

    }
}
