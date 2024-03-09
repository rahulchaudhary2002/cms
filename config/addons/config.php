<?php

return [
    'urls' => [
        'staff',
        'staff/create',
        'staff/store',
        'staff/edit/*',
        'staff/update/*',
        'staff/show/*',
        'student',
        'student/create',
        'student/store',
        'student/edit/*',
        'student/update/*',
        'student/show/*',
        'role',
        'role/create',
        'role/store',
        'role/edit/*',
        'role/update/*',
        'permission',
        'permission/create',
        'permission/store',
        'permission/edit/*',
        'permission/update/*',
        'academic-year',
        'academic-year/create',
        'academic-year/store',
        'academic-year/edit/*',
        'academic-year/update/*',
        'university',
        'university/create',
        'university/store',
        'university/edit/*',
        'university/update/*',
        'program',
        'program/create',
        'program/store',
        'program/edit/*',
        'program/update/*',
        'semester',
        'semester/create',
        'semester/store',
        'semester/edit/*',
        'semester/update/*',
        'semester/assign/*',
        'semester/change',
        'semester/change/*',
        'course',
        'course/create',
        'course/store',
        'course/edit/*',
        'course/update/*',
        'course/assign/*',
        'session',
        'session/create',
        'session/store',
        'session/edit/*',
        'session/update/*',
        'student/attendance',
        'student/attendance/take',
        'student/attendance/store',
        'assignment',
        'assignment/create',
        'assignment/store',
        'assignment/edit/*',
        'assignment/update/*',
        'assignment/show/*',
        'assignment/submission/view/*',
        'assignment/submission/create/*',
        'assignment/submission/store/*',
        'assignment/submission/show/*',
        'assignment/submission/check/*',
        'assignment/submission/checking/*',
        'assignment/upload-file',
        'assignment/remove-file',
        'examination/stage/create',
        'examination/stage/store',
        'examination/stage/edit/*',
        'examination/stage/update/*',
    ],

    'roles' => [
        'Superadmin',
        'Student',
        'Teacher'
    ],

    'permissions' => [
        'permission' => [
            'view permission',
            'create permission',
            'update permission',
        ],

        'role' => [
            'view role',
            'create role',
            'update role',
        ],

        'staff' => [
            'view staff',
            'create staff',
            'update staff',
        ],

        'student' => [
            'view student',
            'create student',
            'update student',
        ],

        'academic-year' => [
            'view academic year',
            'create academic year',
            'update academic year',
        ],

        'university' => [
            'view university',
            'create university',
            'update university',
        ],

        'program' => [
            'view program',
            'create program',
            'update program'
        ],

        'session' => [
            'view session',
            'create session',
            'update session',
        ],

        'semester' => [
            'view semester',
            'create semester',
            'update semester',
            'assign semester'
        ],

        'course' => [
            'view course',
            'create course',
            'update course',
            'assign course',
        ],

        'assignment' => [
            'view assignment',
            'create assignment',
            'update assignment',
            'submit assignment',
        ],

        'assignment-submission' => [
            'view all submission',
            'view submission',
            'check submission'
        ],

        'examination-stage' => [
            'view examination stage',
            'create examination stage',
            'update examination stage',
        ],

        'attendance' => [
            'view attendance',
            'take attendance',
        ],
    ]
];
