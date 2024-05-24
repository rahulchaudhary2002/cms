<?php

namespace App\Interfaces;
        
interface ExaminationRecordRepositoryInterface
{
    public function get($request);
    public function create($request, $examination_stage_id, $student_id);
    public function update($request, $examination_stage_id, $student_id);
}
