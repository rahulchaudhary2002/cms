<?php

namespace App\Imports;

use App\Models\Course;
use App\Models\ExaminationMark;
use App\Models\ExaminationRecord;
use App\Models\ExaminationStage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportExaminationRecrod implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        DB::transaction(function () use ($collection) {
            $examination_stage = $collection[4][1];
            $headings = $collection[6]->toArray();
            $rows = $collection->slice(7);

            unset($headings[0], $headings[1]);
            array_pop($headings);

            foreach ($rows as $row) {
                $data = $row->toArray();
                $examinationStage = ExaminationStage::where('key', $examination_stage)->first();
                $examinationRecord = ExaminationRecord::where('student_id', reset($data))->where('examination_stage_id', $examinationStage->id)->first();

                if ($examinationRecord) {
                    $examinationRecord->update([
                        'gpa' => end($data)
                    ]);

                    $examinationRecord->marks()->delete();
                } else {
                    $examinationRecord = ExaminationRecord::create([
                        'student_id' => reset($data),
                        'examination_stage_id' => $examinationStage->id,
                        'gpa' => end($data)
                    ]);
                }

                unset($data[0], $data[1]);
                array_pop($data);

                foreach ($headings as $key => $heading) {
                    $course = Course::where('course_code', $heading)->first();

                    ExaminationMark::create([
                        'course_id' => $course->id,
                        'examination_record_id' => $examinationRecord->id,
                        'grade' => $data[$key]
                    ]);
                }
            }
        });
    }
}
