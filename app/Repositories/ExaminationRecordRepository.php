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
            $query = $query->whereHas('academicYear', function ($query) use ($request) {
                return $query->where('key', $request->academic_year);
            })->whereHas('program', function ($query) use ($request) {
                return $query->where('key', $request->program);
            })->whereHas('semester', function ($query) use ($request) {
                return $query->where('key', $request->semester);
            })->whereHas('session', function ($query) use ($request) {
                return $query->where('key', $request->session);
            });

            if($request->examination_stage) {
                $query->where('key', $request->examination_stage);
            }
        });

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
}
