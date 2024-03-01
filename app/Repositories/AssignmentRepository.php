<?php

namespace App\Repositories;

use App\Interfaces\AssignmentRepositoryInterface;
use App\Models\Assignment;

class AssignmentRepository implements AssignmentRepositoryInterface
{
    public function get($request)
    {
        $page = $request->page ?? 1;
        $perPage = $request->perPage ?? 10;
        $skip = ($page - 1) * $perPage;

        $assignments = Assignment::select('*');

        if ($request->authUser->hasRole('superadmin')) {
            $assignments = $assignments;
        } else if ($request->authUser->hasRole('student')) {
            $assignments = $assignments->where('academic_year_id', $request->authUser->student->academic_year_id)
                ->where('program_id', $request->authUser->student->program_id)
                ->whereIn('semester_id', $request->authUser->student->semesters->pluck('semester_id'))
                ->whereIn('session_id', $request->authUser->student->semesters->pluck('session_id'))
                ->whereIn('course_id', $request->authUser->student->studentCourses->pluck('course_id'));
        } else {
            $assignments = $assignments->whereHas('creater', function ($query) use ($request) {
                $query->where('created_by', $request->authUser->id);
            });
        }

        if ($request->title) {
            $assignments = $assignments->where('title', 'LIKE', '%' . $request->title . '%');
        }

        if ($request->academic_year) {
            $assignments = $assignments->whereHas('academicYear', function ($query) use ($request) {
                return $query->where('key', $request->academic_year);
            });
        }

        if ($request->program) {
            $assignments = $assignments->whereHas('program', function ($query) use ($request) {
                return $query->where('key', $request->program);
            });
        }

        if ($request->semester) {
            $assignments = $assignments->whereHas('semester', function ($query) use ($request) {
                return $query->where('key', $request->semester);
            });
        }

        if ($request->session) {
            $assignments = $assignments->whereHas('session', function ($query) use ($request) {
                return $query->where('key', $request->session);
            });
        }

        if ($request->course) {
            $assignments = $assignments->whereHas('course', function ($query) use ($request) {
                return $query->where('key', $request->course);
            });
        }

        if($request->type == 'submitted') {
            $assignments = $assignments->whereHas('submissions');
        }

        if($request->type == 'unsubmitted') {
            $assignments = $assignments->doesntHave('submissions');
        }

        if($request->type == 'expired') {
            $assignments = $assignments->whereDate('submission_date', '<', now())->where('late_submission', 0)->doesntHave('authSubmission');
        }

        $totalRecords = $this->count($assignments);
        $assignments = $assignments->latest()->skip($skip)->take($perPage)->get();

        return [
            'currentPage' => $page,
            'recordsPerPage' => $perPage,
            'assignments' => $assignments,
            'totalRecords' => $totalRecords
        ];
    }

    public function count($assignments)
    {
        return $assignments->count();
    }

    public function getById($id)
    {
        return Assignment::findOrFail($id);
    }

    public function getByKey($key)
    {
        return Assignment::where('key', $key)->firstOrFail();
    }

    public function create($request)
    {
        return Assignment::create([
            'title' => $request->title,
            'academic_year_id' => $request->academic_year,
            'program_id' => $request->program,
            'semester_id' => $request->semester,
            'session_id' => $request->session,
            'course_id' => $request->course,
            'description' => $request->description,
            'date_given' => now(),
            'submission_date' => $request->submission_date,
            'late_submission' => $request->allow_late_submission ?? 0,
        ]);
    }

    public function update($request, $key)
    {
        $assignment = $this->getByKey($key);

        $assignment->update([
            'title' => $request->title,
            'academic_year_id' => $request->academic_year,
            'program_id' => $request->program,
            'semester_id' => $request->semester,
            'session_id' => $request->session,
            'course_id' => $request->course,
            'description' => $request->description,
            'submission_date' => $request->submission_date,
            'late_submission' => $request->allow_late_submission ?? 0,
        ]);

        return $assignment;
    }

    public function model()
    {
        return new Assignment();
    }
}
