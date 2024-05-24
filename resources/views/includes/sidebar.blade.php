<div class="sidebar">
    <div class="sidebar-header">
        <h3 class="brand">
            <span class="brand-logo"><img src="{{ asset('assets/images/cms.png') }}"></span>
            <span class="brand-name">{{ env("APP_NAME") ?? "College Management System" }}</span>
        </h3>
        <span class="fa fa-bars"></span>
    </div>

    <ul class="sidebar-menu">
        <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}">
                <span class="sidebar-menu-item">
                    <span class="fa fa-gauge"></span>
                    <span class="sidebar-menu-text">Dashboard</span>
                </span>
            </a>
        </li>
        @if(auth()->user()->can('user.view') || auth()->user()->can('student.view') || auth()->user()->can('role.view') || auth()->user()->can('permission.view'))
        <li class="{{ request()->is('staff') || request()->is('staff/*') || request()->is('student') || request()->is('student/create') || request()->is('student/edit/*') || request()->is('role') || request()->is('role/*') || request()->is('permission') || request()->is('permission/*') || request()->is('semester/assign/*') || request()->is('course/assign/*') || request()->is('staff/show/*') || request()->is('student/show/*') ? 'active' : '' }}">
            <a href="javascript:;">
                <span class="sidebar-menu-item">
                    <span class="fa fa-user-gear"></span>
                    <span class="sidebar-menu-text">Authorization</span>
                </span>
                <span class="fa fa-angle-left"></span>
            </a>
            <ul class="sidebar-sub-menu {{ request()->is('staff') || request()->is('staff/*') || request()->is('student') || request()->is('student/create') || request()->is('student/edit/*') || request()->is('role') || request()->is('role/*') || request()->is('permission') || request()->is('permission/*') || request()->is('semester/assign/*') || request()->is('course/assign/*') || request()->is('staff/show/*') || request()->is('student/show/*') ? 'expand' : '' }}">
                @if(auth()->user()->can('user.view') || auth()->user()->can('student.view'))
                <li class="{{ request()->is('staff') || request()->is('staff/*') || request()->is('student') || request()->is('student/create') || request()->is('student/edit/*') || request()->is('staff/show/*') || request()->is('student/show/*') ? 'active' : '' }}">
                    <a href="javascript:;" class="{{ request()->is('staff') || request()->is('staff/*') || request()->is('student') || request()->is('student/create') || request()->is('student/edit/*') || request()->is('semester/assign/*') || request()->is('course/assign/*') || request()->is('staff/show/*') || request()->is('student/show/*') ? 'active' : '' }}">
                        <span class="sidebar-menu-item">
                            <span class="fa fa-users"></span>
                            <span class="sidebar-menu-text">Users</span>
                        </span>
                        <span class="fa fa-angle-left"></span>
                    </a>
                    <ul class="sidebar-sub-menu {{ request()->is('staff') || request()->is('staff/*') || request()->is('student') || request()->is('student/create') || request()->is('student/edit/*') || request()->is('semester/assign/*') || request()->is('course/assign/*') || request()->is('staff/show/*') || request()->is('student/show/*') ? 'expand' : '' }}">
                        @if(auth()->user()->can('user.view'))
                        <li class="{{ request()->is('staff') || request()->is('staff/*') || request()->is('course/assign/*') || request()->is('staff/show/*') ? 'active' : '' }}">
                            <a href="{{ route('user.index') }}" class="{{ request()->is('staff') || request()->is('staff/*') || request()->is('course/assign/*') || request()->is('staff/show/*') ? 'active' : '' }}">
                                <span class="sidebar-menu-item">
                                    <span class="fa fa-solid fa-circle"></span>
                                    <span class="sidebar-sub-menu-text">Staffs</span>
                                </span>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->can('student.view'))
                        <li class="{{ request()->is('student') || request()->is('student/*') || request()->is('semester/assign/*') || request()->is('student/show/*') ? 'active' : '' }}">
                            <a href="{{ route('student.index') }}" class="{{ request()->is('student') || request()->is('student/create') || request()->is('student/edit/*') || request()->is('semester/assign/*') || request()->is('student/show/*') ? 'active' : '' }}">
                                <span class="sidebar-menu-item">
                                    <span class="fa fa-solid fa-circle"></span>
                                    <span class="sidebar-sub-menu-text">Students</span>
                                </span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if(auth()->user()->can('role.view'))
                <li class="{{ request()->is('role') || request()->is('role/*') ? 'active' : '' }}">
                    <a href="{{ route('role.index') }}" class="{{ request()->is('role') || request()->is('role/*') ? 'active' : '' }}">
                        <span class="sidebar-menu-item">
                            <span class="fa fa-tasks"></span>
                            <span class="sidebar-menu-text">Roles</span>
                        </span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->can('permission.view'))
                <li class="{{ request()->is('permission') || request()->is('permission/*') ? 'active' : '' }}">
                    <a href="{{ route('permission.index') }}" class="{{ request()->is('permission') || request()->is('permission/*') ? 'active' : '' }}">
                        <span class="sidebar-menu-item">
                            <span class="fa fa-lock"></span>
                            <span class="sidebar-menu-text">Permissions</span>
                        </span>
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif
        @if(auth()->user()->can('academic-yer.view') || auth()->user()->can('university.view') || auth()->user()->can('program.view') || auth()->user()->can('semester.view') || auth()->user()->can('course.view') || auth()->user()->can('session.view'))
        <li class="{{ request()->is('academic-year') || request()->is('academic-year/*') || request()->is('university') || request()->is('university/*') || request()->is('program') || request()->is('program/create') || request()->is('program/edit/*') || request()->is('semester') || request()->is('semester/create') || request()->is('semester/edit/*') || request()->is('course') || request()->is('course/create') || request()->is('course/edit/*') || request()->is('session') || request()->is('session/*') ? 'active' : '' }}">
            <a href="javascript:;">
                <span class="sidebar-menu-item">
                    <span class="fa fa-cog"></span>
                    <span class="sidebar-menu-text">Settings</span>
                </span>
                <span class="fa fa-angle-left"></span>
            </a>
            <ul class="sidebar-sub-menu {{ request()->is('academic-year') || request()->is('academic-year/*') || request()->is('university') || request()->is('university/*') || request()->is('program') || request()->is('program/create') || request()->is('program/edit/*') || request()->is('semester') || request()->is('semester/create') || request()->is('semester/edit/*') || request()->is('course') || request()->is('course/create') || request()->is('course/edit/*') || request()->is('session') || request()->is('session/*') ? 'expand' : '' }}">
                @if(auth()->user()->can('academic-year.view'))
                <li class="{{ request()->is('academic-year') || request()->is('academic-year/*') ? 'active' : '' }}">
                    <a href="{{ route('academic-year.index') }}" class="{{ request()->is('academic-year') || request()->is('academic-year/*') ? 'active' : '' }}">
                        <span class="sidebar-menu-item">
                            <span class="fa fa-calendar"></span>
                            <span class="sidebar-menu-text">Academic Years</span>
                        </span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->can('university.view'))
                <li class="{{ request()->is('university') || request()->is('university/*') ? 'active' : '' }}">
                    <a href="{{ route('university.index') }}" class="{{ request()->is('university') || request()->is('university/*') ? 'active' : '' }}">
                        <span class="sidebar-menu-item">
                            <span class="fa fa-university"></span>
                            <span class="sidebar-menu-text">Universities</span>
                        </span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->can('program.view'))
                <li class="{{ request()->is('program') || request()->is('program/create') || request()->is('program/edit/*') ? 'active' : '' }}">
                    <a href="{{ route('program.index') }}" class="{{ request()->is('program') || request()->is('program/create') || request()->is('program/edit/*') ? 'active' : '' }}">
                        <span class="sidebar-menu-item">
                            <span class="fa fa-graduation-cap"></span>
                            <span class="sidebar-menu-text">Programs</span>
                        </span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->can('semester.view'))
                <li class="{{ request()->is('semester') || request()->is('semester/create') || request()->is('semester/edit/*') ? 'active' : '' }}">
                    <a href="{{ route('semester.index') }}" class="{{ request()->is('semester') || request()->is('semester/create') || request()->is('semester/edit/*') ? 'active' : '' }}">
                        <span class="sidebar-menu-item">
                            <span class="fa fa-graduation-cap"></span>
                            <span class="sidebar-menu-text">Semesters</span>
                        </span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->can('course.view'))
                <li class="{{ request()->is('course') || request()->is('course/create') || request()->is('course/edit/*') ? 'active' : '' }}">
                    <a href="{{ route('course.index') }}" class="{{ request()->is('course') || request()->is('course/create') || request()->is('course/edit/*') ? 'active' : '' }}">
                        <span class="sidebar-menu-item">
                            <span class="fa fa-book"></span>
                            <span class="sidebar-menu-text">Courses</span>
                        </span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->can('session.view'))
                <li class="{{ request()->is('session') || request()->is('session/*') ? 'active' : '' }}">
                    <a href="{{ route('session.index') }}" class="{{ request()->is('session') || request()->is('session/*') ? 'active' : '' }}">
                        <span class="sidebar-menu-item">
                            <span class="fa fa-hourglass-start"></span>
                            <span class="sidebar-menu-text">Sessions</span>
                        </span>
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif
        @if(auth()->user()->can('student-attendance.view'))
        <li class="{{ request()->is('student/attendance') || request()->is('student/attendance/take') ? 'active' : '' }}">
            <a href="{{ route('student.attendance.index') }}">
                <span class="sidebar-menu-item">
                    <span class="fa fa-clock"></span>
                    <span class="sidebar-menu-text">Attendance</span>
                </span>
            </a>
        </li>
        @endif
        @if(auth()->user()->can('assignment.view'))
        <li class="{{ request()->is('assignment') || request()->is('assignment/*') ? 'active' : '' }}">
            <a href="{{ route('assignment.index') }}">
                <span class="sidebar-menu-item">
                    <span class="fa fa-tasks"></span>
                    <span class="sidebar-menu-text">Assignment</span>
                </span>
            </a>
        </li>
        @endif
        @if(auth()->user()->can('examination-stage.view') || auth()->user()->can('examination-record.view'))
        <li class="{{ request()->is('examination/*') ? 'active' : '' }}">
            <a href="javascript:;">
                <span class="sidebar-menu-item">
                    <span class="fa fa-book-reader"></span>
                    <span class="sidebar-menu-text">Examination</span>
                </span>
                <span class="fa fa-angle-left"></span>
            </a>
            <ul class="sidebar-sub-menu {{ request()->is('examination/*') ? 'expand' : '' }}">
                @if(auth()->user()->can('examination-stage.view'))
                <li class="{{ request()->is('examination/stage') || request()->is('examination/stage/*') ? 'active' : '' }}">
                    <a href="{{ route('examination.stage.index') }}" class="{{ request()->is('examination/stage') || request()->is('examination/stage/*') ? 'active' : '' }}">
                        <span class="sidebar-menu-item">
                            <span class="fa fa-circle"></span>
                            <span class="sidebar-menu-text">Stage</span>
                        </span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->can('examination-record.view'))
                <li class="{{ request()->is('examination/record') || request()->is('examination/record/*') ? 'active' : '' }}">
                    <a href="{{ route('examination.record.index') }}" class="{{ request()->is('examination/record') || request()->is('examination/record/*') ? 'active' : '' }}">
                        <span class="sidebar-menu-item">
                            <span class="fa fa-circle"></span>
                            <span class="sidebar-menu-text">Record</span>
                        </span>
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif
    </ul>
</div>