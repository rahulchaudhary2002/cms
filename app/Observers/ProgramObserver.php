<?php

namespace App\Observers;

use App\Models\Program;

class ProgramObserver extends BaseObserver
{
    public function creating(Program $program): void
    {
        $this->generateKey(Program::class, $program);
    }
}
