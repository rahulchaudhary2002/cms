<?php

use App\Models\AssignmentAnswer;
use App\Models\Program;
use App\Models\Student;

if (!function_exists('getProgramByKey')) {
	function getProgramByKey($key)
	{
		return Program::where('key', $key)->first() ?? null;
	}
}

if (!function_exists('countAssignmentStudents')) {
	function countAssignmentStudents($assignment)
	{
		return Student::where('academic_year_id', $assignment->academic_year_id)
			->where('program_id', $assignment->program_id)
			->whereHas('semesters', function ($query) use ($assignment) {
				$query->where('semester_id', $assignment->semester_id)
					->where('session_id', $assignment->session_id);
			})
			->whereHas('studentCourses', function ($query) use ($assignment) {
				$query->where('semester_id', $assignment->semester_id)
					->where('course_id', $assignment->course_id);
			})->count();
	}
}

if (!function_exists('getAnswer')) {
	function getAnswer($question, $submission_id)
	{
		return AssignmentAnswer::where('assignment_submission_id', $submission_id)
			->where('assignment_question_id', $question->id)->first();
	}
}

if (!function_exists('examinationRecords')) {
	function examinationRecord($student, $examination_stage)
	{
		return $student->student->examinationRecords()->whereHas('examinationStage', function ($query) use ($examination_stage) {
			$query->where('name', $examination_stage);
		})->first();
	}
}

if (!function_exists('studentCourses')) {
	function studentCourses($student, $examination_stage)
	{
		return $student->student->studentCourses()->whereHas('course', function ($query) use ($examination_stage) {
			$query->where('semester_id', $examination_stage->semester_id);
		})->get();
	}
}
