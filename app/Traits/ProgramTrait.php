<?php

namespace App\Traits;
        
trait ProgramTrait
{
    public function getPrograms()
    {
        return $this->programRepository->model()->get();
    }
}
