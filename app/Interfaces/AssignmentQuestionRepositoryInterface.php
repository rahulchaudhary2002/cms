<?php

namespace App\Interfaces;
        
interface AssignmentQuestionRepositoryInterface
{
    public function create($request, $id);
    public function update($request, $id);
}
