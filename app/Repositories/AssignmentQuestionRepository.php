<?php

namespace App\Repositories;

use App\Interfaces\AssignmentQuestionRepositoryInterface;
use App\Models\AssignmentQuestion;

class AssignmentQuestionRepository implements AssignmentQuestionRepositoryInterface
{
    public function create($request, $id)
    {  
        if(is_array($request->question_titles)) {
            foreach($request->question_titles as $key => $question_title) {
                AssignmentQuestion::create([
                    'assignment_id' => $id,
                    'question' => $question_title,
                    'description' => $request->question_descriptions[$key],
                    'answer_type' => $request->answer_types[$key],
                    'multiple_upload' => ($request->answer_types[$key] == 'File Upload') ? $request->multiple_file_uploads[$key] : 0
                ]);  
            }
        }

        return true;
    }

    public function update($request, $id)
    {
        $this->delete($id);

        $this->create($request, $id);

        return true;
    }

    public function delete($assignment)
    {
        AssignmentQuestion::where('assignment_id', $assignment)->delete();
    }
}
