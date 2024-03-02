@extends('layouts.app')

@section('title', 'Show Student')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('student.index') }}">Student</a></li>
    <li class="breadcrumb-item">Show</li>
</ul>
@endsection

@section('content')
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
                            <span class="user-role">{{ $user->student->program->name }} | {{ $user->student->semester()->latest()->first()->semester->name ?? "" }}</span>
                        </div>
                    </div>
                    <div class="accordion d-flex-center gap-2 f-6">
                        <a class="active" href="javascript:;" data-target="#personal-info"><span class="fa fa-user"></span> Personal Information</a>
                        <a href="javascript:;" data-target="#semester-info"><span class="fa fa-graduation-cap"></span> Semesters</a>
                    </div>
                    <div class="card-setting d-flex gap-2">
                        <a class="text-danger" href="{{ route('student.index') }}"><span class="fa fa-arrow-left"></span></a>
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
                                    @if(auth()->user()->can('user.edit') && $user->is_super == 0)
                                    <a class="btn btn-sm btn-gray" href="{{ route('student.edit', $user->key) }}"><span class="fa fa-edit"></span></a>
                                    @endif
                                    <a class="btn btn-sm btn-gray" href="#"><span class="fa fa-print"></span></a>
                                    <a class="btn btn-sm btn-gray" href="#"><span class="fa fa-download"></span></a>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    </div>
</div>

@endsection