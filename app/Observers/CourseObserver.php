<?php

namespace App\Observers;

use App\Models\Course;

class CourseObserver extends BaseObserver
{
    public function creating(Course $course): void
    {
        $this->generateKey(Course::class, $course);
    }
}
