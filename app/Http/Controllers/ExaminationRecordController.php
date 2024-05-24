<?php

namespace App\Http\Controllers;

use App\Exports\ExaminationRecordTemplate;
use App\Http\Requests\Examination\CreateExaminationRecordRequest;
use App\Http\Requests\Examination\ImportExaminationRecordRequest;
use App\Http\Requests\Examination\UpdateExaminationRecordRequest;
use App\Imports\ImportExaminationRecrod;
use App\Services\ExaminationRecordService;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

        if(auth()->user()->student) {
            $result = (object) $this->examinationRecordService->getExaminationRecords($request);
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

        if(examinationRecord($student, $examinationStageKey)) {
            abort(404);
        }
        
        return view('modules.examination.record.create', compact('examinationStage', 'student'));
    }

    public function store(CreateExaminationRecordRequest $request, $examinationStageKey, $studentKey)
    {
        if($this->examinationRecordService->createExaminationRecord($request, $examinationStageKey, $studentKey)) {
            return redirect()->route('examination.record.index')->with('success', 'Examination record is created!');
        }
        return redirect()->route('examination.record.index')->with('error', 'Examination record is not created!');
    }

    public function edit($examinationStageKey, $studentKey)
    {
        $examinationStage = $this->examinationRecordService->getExaminationStageByKey($examinationStageKey);
        $student = $this->examinationRecordService->getUserByKey($studentKey);
        $record = examinationRecord($student, $examinationStageKey);
        
        if(!$record) {
            abort(404);
        }
        
        return view('modules.examination.record.edit', compact('examinationStage', 'student', 'record'));
    }

    public function update(UpdateExaminationRecordRequest $request, $examinationStageKey, $studentKey)
    {
        if($this->examinationRecordService->updateExaminationRecord($request, $examinationStageKey, $studentKey)) {
            return redirect()->route('examination.record.index')->with('success', 'Examination record is updated!');
        }
        return redirect()->route('examination.record.index')->with('error', 'Examination record is not updated!');
    }

    public function show($examinationStageKey, $studentKey)
    {
        $student = $this->examinationRecordService->getUserByKey($studentKey);
        $record = examinationRecord($student, $examinationStageKey);

        if(!$record || (auth()->user()->student && auth()->user()->key != $studentKey)) {
            abort(404);
        }

        return view('modules.examination.record.show', compact('record'));
    }

    public function exportTemplate(Request $request)
    {
        $request['perPage'] = 100;
        $data = (object) $this->examinationRecordService->getStudents($request);
        $headings = $this->examinationRecordService->getHeadings($request);
        
        return Excel::download(new ExaminationRecordTemplate($request, $data->students, $headings), 'templete.xlsx');
    }

    public function importForm()
    {
        return view('modules.examination.record.import');
    }

    public function import(ImportExaminationRecordRequest $request)
    {
        try {
            Excel::import(new ImportExaminationRecrod, $request->file('file'));

            return redirect()->route('examination.record.index')->with('success', 'Examination record is imported!');
        }
        catch (Exception $e) {
            return redirect()->route('examination.record.index')->with('error', 'Examination record is not imported!');
        }
    }
}
