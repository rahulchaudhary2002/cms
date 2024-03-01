<?php

namespace App\Repositories;

use App\Interfaces\StudentAttendanceRepositoryInterface;
use App\Models\StudentAttendance;
use Exception;

class StudentAttendanceRepository implements StudentAttendanceRepositoryInterface
{
    public function create($request)
    {
        try {
            $attendance = new StudentAttendance();
            $attendance->setTable('student_attendances_' . date('Ym', strtotime($request->date)));

            foreach ($request->students as $student_id) {
                $attendance->create([
                    'student_id' => $student_id,
                    'course_id' => $request->course,
                    'date' => $request->date,
                    'status' => $request->status[$student_id]
                ]);
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function model()
    {
        return new StudentAttendance();
    }
}
