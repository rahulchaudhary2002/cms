<?php

namespace App\Services;

use App\Interfaces\AcademicYearRepositoryInterface;
use App\Interfaces\AssignmentAnswerRepositoryInterface;
use App\Interfaces\AssignmentQuestionRepositoryInterface;
use App\Interfaces\AssignmentRepositoryInterface;
use App\Interfaces\AssignmentSubmissionRepositoryInterface;
use App\Interfaces\CourseRepositoryInterFace;
use App\Interfaces\ProgramRepositoryInterFace;
use App\Interfaces\SemesterRepositoryInterFace;
use App\Interfaces\SessionRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class AssignmentService
{
    private AssignmentRepositoryInterface $assignmentRepository;
    private AssignmentQuestionRepositoryInterface $assignmentQuestionRepository;
    private AssignmentSubmissionRepositoryInterface $assignmentSubmissionRepository;
    private AssignmentAnswerRepositoryInterface $assignmentAnswerRepository;
    private ProgramRepositoryInterFace $programRepository;
    private SemesterRepositoryInterFace $semesterRepository;
    private AcademicYearRepositoryInterface $academicYearRepository;
    private SessionRepositoryInterface $sessionRepository;
    private CourseRepositoryInterFace $courseRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(AssignmentRepositoryInterface $assignmentRepository, AssignmentQuestionRepositoryInterface $assignmentQuestionRepository, AssignmentSubmissionRepositoryInterface $assignmentSubmissionRepository, AssignmentAnswerRepositoryInterface $assignmentAnswerRepository, ProgramRepositoryInterFace $programRepository, SemesterRepositoryInterFace $semesterRepository, AcademicYearRepositoryInterface $academicYearRepository, SessionRepositoryInterface $sessionRepository, CourseRepositoryInterFace $courseRepository, UserRepositoryInterface $userRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
        $this->assignmentQuestionRepository = $assignmentQuestionRepository;
        $this->assignmentSubmissionRepository = $assignmentSubmissionRepository;
        $this->assignmentAnswerRepository = $assignmentAnswerRepository;
        $this->academicYearRepository = $academicYearRepository;
        $this->programRepository = $programRepository;
        $this->semesterRepository = $semesterRepository;
        $this->sessionRepository = $sessionRepository;
        $this->courseRepository = $courseRepository;
        $this->userRepository = $userRepository;
    }

    public function getAssignments($request)
    {
        $user = $this->userRepository->getById(auth()->user()->id);
        $request->merge(['authUser' => $user]);
        
        return $this->assignmentRepository->get($request);
    }

    public function getAssignmentByKey($key)
    {
        return $this->assignmentRepository->getByKey($key);
    }

    public function getAcademicYear()
    {
        return $this->academicYearRepository->model()->get();
    }

    public function getPrograms()
    {
        return $this->programRepository->model()->get();
    }

    public function getSemestersWithProgram()
    {
        $user = $this->userRepository->getById(auth()->user()->id);

        if($user->hasRole('student')) {
            return $this->semesterRepository->model()->with('program')->whereHas('studentSemesters', function ($query) use ($user) {
                $query->where('student_id', $user->student->id);
            })->get();
        }

        return $this->semesterRepository->getWithRelation('program');
    }

    public function getSessionsWithAcademicYearSemesterAndProgram()
    {
        $user = $this->userRepository->getById(auth()->user()->id);

        if ($user->hasRole('superadmin')) {
            return $this->sessionRepository->getWithRelation(['academicYear', 'semester', 'program']);
        }

        if ($user->hasRole('teacher')) {
            return $this->sessionRepository->model()->with(['academicYear', 'semester', 'program'])->whereHas('teacherCourses', function ($query) use ($user) {
                $query->where('teacher_id', $user->teacher->id);
            })->get();
        }

        if($user->hasRole('student')) {
            // return $this->sessionRepository->model()->with(['academicYear', 'semester', 'program'])->whereHas('studentSemesters', function ($query) use ($user) {
            //     $query->where('student_id', $user->student->id);
            // })->get();

            return [];
        }

        return $this->sessionRepository->getWithRelation(['academicYear', 'semester', 'program']);
    }

    public function getCoursesWithSemester()
    {
        $user = $this->userRepository->getById(auth()->user()->id);

        if ($user->hasRole('superadmin')) {
            return $this->courseRepository->getWithRelation(['semester']);
        }

        if ($user->hasRole('teacher')) {
            return $this->courseRepository->model()->with(['semester', 'teacherCourses.session'])->whereHas('teacherCourses', function ($query) use ($user) {
                $query->where('teacher_id', $user->teacher->id);
            })->get();
        }

        if($user->hasRole('student')) {
            return $this->courseRepository->model()->with(['semester'])->whereHas('studentCourses', function ($query) use ($user) {
                $query->where('student_id', $user->student->id);
            })->get();
        }

        return $this->courseRepository->getWithRelation(['semester']);
    }

    public function createAssignment($request)
    {
        try {
            $assignment = null;

            DB::transaction(function () use ($request, &$assignment) {
                $assignment = $this->assignmentRepository->create($request);
                $this->assignmentQuestionRepository->create($request, $assignment->id);
            });

            return $assignment;
        } catch (Exception $e) {
            return false;
        }
    }

    public function updateAssignment($request, $key)
    {
        try {
            $assignment = null;

            DB::transaction(function () use ($request, &$assignment, $key) {
                $assignment = $this->assignmentRepository->update($request, $key);
                $this->assignmentQuestionRepository->update($request, $assignment->id);
            });

            return $assignment;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getAssignmentSubmission($key, $student_key)
    {
        $assignment = $this->getAssignmentByKey($key);

        return $assignment->submissions()->whereHas('student', function ($query) use ($student_key) {
            $query->whereHas('user', function ($query) use ($student_key) {
                $query->where('key', $student_key);
            });
        })->firstOrFail();
    }

    public function storeSubmission($request, $key)
    {
        try {
            $submission = null;
            $assignment = $this->assignmentRepository->getByKey($key);

            DB::transaction(function () use ($request, &$submission, $assignment) {
                $submission = $this->assignmentSubmissionRepository->create($request, $assignment->id);
                $this->assignmentAnswerRepository->create($request, $submission);
            });

            return $submission;
        } catch (Exception $e) {
            return false;
        }
    }

    public function checkSubmission($request, $key, $student_key)
    {
        try {
            $submission = null;
            $assignment = $this->assignmentRepository->getByKey($key);
            $user = $this->userRepository->getByKey($student_key);

            DB::transaction(function () use ($request, &$submission, $assignment, $user) {
                $submission = $this->assignmentSubmissionRepository->update($request, $assignment->id, $user->student->id);
                $this->assignmentAnswerRepository->update($request);
            });

            return $submission;
        } catch (Exception $e) {
            dd($e);
            return false;
        }
    }
}
