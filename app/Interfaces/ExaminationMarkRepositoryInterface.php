<?php

namespace App\Interfaces;
        
interface ExaminationMarkRepositoryInterface
{
    public function create($request, $recordId);
    public function update($request, $recordId);
}
