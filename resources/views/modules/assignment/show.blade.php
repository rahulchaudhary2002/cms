@extends('layouts.app')

@section('title', 'Show Assignment')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('assignment.index') }}">Assignment</a></li>
    <li class="breadcrumb-item">Show Assignment</li>
</ul>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between align-center">
                    <h1 class="card-title">Assignment of {{ $assignment->program->name }}-{{ $assignment->semester->name }} ({{ $assignment->academicYear->name }} {{ $assignment->session->name }}) : {{ $assignment->course->name }}</h1>
                    <div class="card-setting d-flex gap-1">
                        @if(auth()->user()->can('assignment-submission.viewAny') && !auth()->user()->hasRole('student'))
                        <a class="text-primary mr-1" title="View Submissions" href="{{ route('assignment.submission.index', $assignment->key) }}"><span class="fa fa-eye"></span></a>
                        @endif
                        @if(count($assignment->submissions) == 0 && auth()->user()->can('assignment.update'))
                        <a class="text-warning mr-1" title="Edit Assignment" href="{{ route('assignment.edit', $assignment->key) }}"><span class="fa fa-edit"></span></a>
                        @endif
                        @if(auth()->user()->hasRole('student'))
                        @if(($assignment->submission_date >= now()->format('Y-m-d') || $assignment->late_submission == 1) && !$assignment->authSubmission)
                        <a class="text-success" title="Start Submission" href="{{ route('assignment.submission.create', $assignment->key) }}"><span class="fa fa-paper-plane"></span></a>
                        @endif
                        @endif
                        <a class="text-danger" title="Back" href="{{ route('assignment.index') }}"><span class="fa fa-arrow-left"></span></a>
                    </div>
                </div>
                <div class="card-body expand">
                    <div class="row">
                        <div class="col-md-12">
                            <strong>{{ $assignment->title }}</strong>
                            <div class="mt-2 mb-2">{!! $assignment->description !!}</div>
                            <span class="fa fa-calendar"></span> Submission Date: {{ $assignment->submission_date }} <span class="text-warning">(Note: {{ $assignment->late_submission == 1 ? 'Late submission is allowed!' : 'Late submission is not allowed!' }})</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach($assignment->questions as $key => $question)
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex-space-between align-center">
                    <h4>Question-{{ $key + 1 }}</h4>
                </div>
                <div class="card-body expand">
                    <div class="row">
                        <div class="col-md-12">
                            <strong>{{ $question->question }}</strong>
                            <div class="mt-2 mb-2">{!! $question->description !!}</div>
                            <span class="fa fa-pencil"></span> {{ $question->answer_type }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('page-specific-script')

@endsection