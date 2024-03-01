<?php

namespace App\Interfaces;
        
interface AssignmentAnswerRepositoryInterface
{
    public function create($request, $submission);
    public function update($request);
}
