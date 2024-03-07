@extends('layouts.app')

@section('title', 'Profile')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item">Profile</li>
</ul>
@endsection

@section('content')
@php $user = auth()->user(); @endphp
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-rounded">
                <div class="card-body d-flex-space-between align-center">
                    <div class="user d-flex gap-1 align-center">
                        <div class="user-img">
                            <img src="{{ $user->image ? asset('storage/users/'.$user->image) : asset('assets/images/noimage.jpg') }}" alt="{{ $user->name }}">
                        </div>
                        <div class="user-title">
                            <strong class="user-name">{{ $user->name }}</strong>
                            <span class="user-role">{{ $user->roles()->first()->role->name }}</span>
                        </div>
                    </div>
                    <div class="accordion d-flex-center gap-2 f-6">
                        @if($user->is_super == 0)
                        <a class="active" href="javascript:;" data-target="#personal-info">
                            <sapn class="fa fa-user"></sapn> Personal Information
                        </a>
                        @endif
                        @if($user->hasRole('teacher'))
                        <a href="javascript:;" data-target="#course-info"><span class="fa fa-book"></span> Courses</a>
                        @endif
                        @if($user->hasRole('student'))
                        <a href="javascript:;" data-target="#semester-info"><span class="fa fa-graduation-cap"></span> Semesters</a>
                        @endif
                    </div>
                    <div class="card-setting d-flex gap-2">
                        <a class="text-danger" href="{{ route('dashboard') }}"><span class="fa fa-arrow-left"></span></a>
                    </div>
                </div>
            </div>
        </div>
        <div id="personal-info" class="col-md-12 accordion-item">
            <div class="card">
                <div class="card-body expand">
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <img class="detail-img" src="{{ $user->image ? asset('storage/users/'.$user->image) : asset('assets/images/noimage.jpg') }}" alt="{{ $user->name }}">
                        </div>
                        <div class="col-md-8 col-sm-12 mt-2">
                            <div class="d-flex-space-between align-center">
                                <strong class="card-title">Personal Information</strong>
                                <div class="card-setting d-flex gap-1">
                                    @if($user->can('user.edit') && $user->hasRole('superadmin'))
                                    <a class="btn btn-sm btn-gray" href="{{ route('user.edit', $user->key) }}"><span class="fa fa-edit"></span></a>
                                    @endif
                                </div>
                            </div>
                            <div class="row line-height-2">
                                <div class="col-md-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-md-4">Name :</div>
                                        <div class="col-md-8">{{ $user->name }}</div>
                                        <div class="col-md-4">Date of Birth :</div>
                                        <div class="col-md-8">{{ $user->dob }}</div>
                                        <div class="col-md-4">Phone :</div>
                                        <div class="col-md-8">{{ $user->mobile }}</div>
                                        <div class="col-md-4">Email :</div>
                                        <div class="col-md-8">{{ $user->email }}</div>
                                        <div class="col-md-4">Temporary Address :</div>
                                        <div class="col-md-8">{{ $user->temporary_address }}</div>
                                        <div class="col-md-4">Permanent Address :</div>
                                        <div class="col-md-8">{{ $user->permanent_address }}</div>
                                        <div class="col-md-4">Nationality :</div>
                                        <div class="col-md-8">{{ $user->nationality ?? 'N/A' }}</div>
                                        @if($user->hasRole('student'))
                                        <div class="col-md-4">Academic Year :</div>
                                        <div class="col-md-8">{{ $user->student->academicYear->name }}</div>
                                        <div class="col-md-4">Program :</div>
                                        <div class="col-md-8">{{ $user->student->program->name }}</div>
                                        <div class="col-md-4">Semester :</div>
                                        <div class="col-md-8">{{ $user->student->semester->semester->name ?? "N/A" }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($user->hasRole('teacher'))
        <div id="course-info" class="col-md-12 accordion-item hide hidden">
            <div class="row">
                @forelse($user->teacher->teacherCourses()->latest()->get() as $course)
                <div class="col-md-3">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <div class="text-center"><strong>{{ $course->course->name }} ({{ $course->course->course_code }})</strong></div>
                            <div class="row mt-2">
                                <div class="col-md-12 mt-2">
                                    Academic Year: {{ $course->session->academicYear->name }}
                                </div>
                                <div class="col-md-12 mt-2">
                                    Program: {{ $course->session->program->name }}
                                </div>
                                <div class="col-md-12 mt-2">
                                    Semester: {{ $course->session->semester->name }}
                                </div>
                                <div class="col-md-12 mt-2">
                                    Session: {{ $course->session->name }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            {{ $user->name }} is not yet assigned any courses.
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
        @endif
        @if($user->hasRole('student'))
        <div id="semester-info" class="col-md-12 accordion-item hide hidden">
            <div class="row">
                @forelse($user->student->semesters as $semester)
                <div class="col-md-3">
                    <div class="card card-rounded">
                        <div class="card-body">
                            @if($user->student->semester->semester_id == $semester->semester_id)
                            <span class="text-success pull-right">Active</span>
                            @endif
                            <div class="d-flex-center align-center" style="height: 100px;">
                                <h3>{{ $semester->semester->name }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            {{ $user->name }} is not yet assigned any semester.
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
        @endif
    </div>
</div>

@endsection