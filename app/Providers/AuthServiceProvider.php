<?php

namespace App\Providers;

use App\Policies\AcademicYearPolicy;
use App\Policies\AssignCoursePolicy;
use App\Policies\AssignmentPolicy;
use App\Policies\AssignmentSubmissionPolicy;
use App\Policies\AssignSemesterPolicy;
use App\Policies\CheckAssignmentSubmissionPolicy;
use App\Policies\CoursePolicy;
use App\Policies\ExaminationStagePolicy;
use App\Policies\PermissionPolicy;
use App\Policies\ProgramPolicy;
use App\Policies\RolePolicy;
use App\Policies\SemesterPolicy;
use App\Policies\SessionPolicy;
use App\Policies\StudentAttendancePolicy;
use App\Policies\StudentPolicy;
use App\Policies\UniversityPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        
        Gate::resource('user', UserPolicy::class);
        Gate::resource('student', StudentPolicy::class);
        Gate::resource('role', RolePolicy::class);
        Gate::resource('permission', PermissionPolicy::class);
        Gate::resource('academic-year', AcademicYearPolicy::class);
        Gate::resource('university', UniversityPolicy::class);
        Gate::resource('program', ProgramPolicy::class);
        Gate::resource('semester', SemesterPolicy::class);
        Gate::resource('course', CoursePolicy::class);
        Gate::resource('session', SessionPolicy::class);
        Gate::resource('assign-semester', AssignSemesterPolicy::class);
        Gate::resource('assign-course', AssignCoursePolicy::class);
        Gate::resource('student-attendance', StudentAttendancePolicy::class);
        Gate::resource('assignment', AssignmentPolicy::class);
        Gate::resource('assignment-submission', AssignmentSubmissionPolicy::class);
        Gate::resource('check-assignment-submission', CheckAssignmentSubmissionPolicy::class);
        Gate::resource('examination-stage', ExaminationStagePolicy::class);

        Gate::before(function ($user, $ability) {
            return $user->hasRole('superadmin') ? true : null;
        });
    }
}
