<?php

namespace App\Repositories;

use App\Interfaces\ExaminationRecordRepositoryInterface;
use App\Models\ExaminationRecord;

class ExaminationRecordRepository implements ExaminationRecordRepositoryInterface
{
    public function get($request)
    {
        $page = $request->page ?? 1;
        $perPage = $request->perPage ?? 10;
        $skip = ($page - 1) * $perPage;

        $examinationRecords = ExaminationRecord::select('*')->whereHas('examinationStage', function ($query) use ($request) {
            if ($request->academic_year) {
                $query = $query->whereHas('academicYear', function ($query) use ($request) {
                    return $query->where('key', $request->academic_year);
                });
            }

            if ($request->program) {
                $query = $query->whereHas('program', function ($query) use ($request) {
                    return $query->where('key', $request->program);
                });
            }

            if ($request->semester) {
                $query = $query->whereHas('semester', function ($query) use ($request) {
                    return $query->where('key', $request->semester);
                });
            }

            if ($request->session) {
                $query = $query->whereHas('session', function ($query) use ($request) {
                    return $query->where('key', $request->session);
                });
            }

            if ($request->examination_stage) {
                $query = $query->where('key', $request->examination_stage);
            }
        });

        if(auth()->user()->student) {
            $examinationRecords = $examinationRecords->where('student_id', auth()->user()->student->id);
        }

        $totalRecords = $this->count($examinationRecords);
        $examinationRecords = $examinationRecords->skip($skip)->take($perPage)->get();

        return [
            'currentPage' => $page,
            'recordsPerPage' => $perPage,
            'examinationRecords' => $examinationRecords,
            'totalRecords' => $totalRecords
        ];
    }

    public function count($examinationRecords)
    {
        return $examinationRecords->count();
    }

    public function create($request, $examination_stage_id, $student_id)
    {
        return ExaminationRecord::create([
            'student_id' => $student_id,
            'examination_stage_id' => $examination_stage_id,
            'gpa' => $request->gpa
        ]);
    }

    public function update($request, $examination_stage_id, $student_id)
    {
        $record = ExaminationRecord::where('student_id', $student_id)->where('examination_stage_id', $examination_stage_id)->first();

        $record->update([
            'gpa' => $request->gpa
        ]);

        return $record;
    }
}
