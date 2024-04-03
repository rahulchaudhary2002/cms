<?php

namespace App\Providers;

use App\Interfaces\AcademicYearRepositoryInterface;
use App\Interfaces\AssignmentAnswerRepositoryInterface;
use App\Interfaces\AssignmentQuestionRepositoryInterface;
use App\Interfaces\AssignmentRepositoryInterface;
use App\Interfaces\AssignmentSubmissionRepositoryInterface;
use App\Interfaces\CourseRepositoryInterFace;
use App\Interfaces\ExaminationMarkRepositoryInterface;
use App\Interfaces\ExaminationRecordRepositoryInterface;
use App\Interfaces\ExaminationStageRepositoryInterface;
use App\Interfaces\PermissionRepositoryInterface;
use App\Interfaces\ProgramRepositoryInterFace;
use App\Interfaces\RoleRepositoryInterface;
use App\Interfaces\SemesterRepositoryInterFace;
use App\Interfaces\SessionRepositoryInterface;
use App\Interfaces\StudentAttendanceRepositoryInterface;
use App\Interfaces\StudentCourseRepositoryInterface;
use App\Interfaces\StudentRepositoryInterface;
use App\Interfaces\StudentSemesterRepositoryInterface;
use App\Interfaces\TeacherCourseRepositoryInterface;
use App\Interfaces\TeacherRepositoryInterface;
use App\Interfaces\UniversityRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\AcademicYearRepository;
use App\Repositories\AssignmentAnswerRepository;
use App\Repositories\AssignmentQuestionRepository;
use App\Repositories\AssignmentRepository;
use App\Repositories\AssignmentSubmissionRepository;
use App\Repositories\CourseRepository;
use App\Repositories\ExaminationMarkRepository;
use App\Repositories\ExaminationRecordRepository;
use App\Repositories\ExaminationStageRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\ProgramRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SemesterRepository;
use App\Repositories\SessionRepository;
use App\Repositories\StudentAttendanceRepository;
use App\Repositories\StudentCourseRepository;
use App\Repositories\StudentRepository;
use App\Repositories\StudentSemesterRepository;
use App\Repositories\TeacherCourseRepository;
use App\Repositories\TeacherRepository;
use App\Repositories\UniversityRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
        $this->app->bind(TeacherRepositoryInterface::class, TeacherRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(AcademicYearRepositoryInterface::class, AcademicYearRepository::class);
        $this->app->bind(UniversityRepositoryInterface::class, UniversityRepository::class);
        $this->app->bind(ProgramRepositoryInterFace::class, ProgramRepository::class);
        $this->app->bind(SemesterRepositoryInterFace::class, SemesterRepository::class);
        $this->app->bind(CourseRepositoryInterFace::class, CourseRepository::class);
        $this->app->bind(SessionRepositoryInterface::class, SessionRepository::class);
        $this->app->bind(StudentSemesterRepositoryInterface::class, StudentSemesterRepository::class);
        $this->app->bind(StudentCourseRepositoryInterface::class, StudentCourseRepository::class);
        $this->app->bind(TeacherCourseRepositoryInterface::class, TeacherCourseRepository::class);
        $this->app->bind(StudentAttendanceRepositoryInterface::class, StudentAttendanceRepository::class);
        $this->app->bind(AssignmentRepositoryInterface::class, AssignmentRepository::class);
        $this->app->bind(AssignmentQuestionRepositoryInterface::class, AssignmentQuestionRepository::class);
        $this->app->bind(AssignmentSubmissionRepositoryInterface::class, AssignmentSubmissionRepository::class);
        $this->app->bind(AssignmentAnswerRepositoryInterface::class, AssignmentAnswerRepository::class);
        $this->app->bind(ExaminationStageRepositoryInterface::class, ExaminationStageRepository::class);
        $this->app->bind(ExaminationRecordRepositoryInterface::class, ExaminationRecordRepository::class);
        $this->app->bind(ExaminationMarkRepositoryInterface::class, ExaminationMarkRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
