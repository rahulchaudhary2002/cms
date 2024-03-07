<?php

namespace App\Observers;

use App\Models\ExaminationStage;

class ExaminationStageObserver extends BaseObserver
{
    public function creating(ExaminationStage $examinationStage): void
    {
        $this->generateKey(ExaminationStage::class, $examinationStage);
    }
}
