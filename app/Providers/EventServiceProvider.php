<?php

namespace App\Providers;

use App\Models\AcademicYear;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Permission;
use App\Models\Program;
use App\Models\Role;
use App\Models\Semester;
use App\Models\Session;
use App\Models\University;
use App\Models\User;
use App\Observers\AcademicYearObserver;
use App\Observers\AssignmentObserver;
use App\Observers\CourseObserver;
use App\Observers\PermissionObserver;
use App\Observers\ProgramObserver;
use App\Observers\RoleObserver;
use App\Observers\SemesterObserver;
use App\Observers\SessionObserver;
use App\Observers\UniversityObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Permission::observe(PermissionObserver::class);
        Role::observe(RoleObserver::class);
        AcademicYear::observe(AcademicYearObserver::class);
        University::observe(UniversityObserver::class);
        Program::observe(ProgramObserver::class);
        Semester::observe(SemesterObserver::class);
        Course::observe(CourseObserver::class);
        Session::observe(SessionObserver::class);
        Assignment::observe(AssignmentObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
