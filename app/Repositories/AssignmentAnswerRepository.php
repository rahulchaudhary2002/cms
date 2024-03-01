<?php

namespace App\Repositories;

use App\Interfaces\AssignmentAnswerRepositoryInterface;
use App\Models\AssignmentAnswer;
use Exception;

class AssignmentAnswerRepository implements AssignmentAnswerRepositoryInterface
{
    public function create($request, $submission)
    {
        foreach ($request->answers as $question => $types) {
            foreach ($types as $type => $answer) {
                AssignmentAnswer::create([
                    'assignment_submission_id' => $submission->id,
                    'assignment_question_id' => $question,
                    'answer' => ($type == 'write') ? $answer[0] : null,
                    'uploads' => ($type == 'file') ? json_encode($answer) : null
                ]);
            }
        }

        return true;
    }

    public function update($request)
    {
        foreach ($request->grades as $answer => $grade) {
            AssignmentAnswer::where('id', $answer)->update([
                'grade' => $grade,
                'comment' => $request->comments[$answer]
            ]);
        }

        return true;
    }
}
