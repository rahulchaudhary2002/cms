@extends('layouts.app')

@section('title', 'Manage Assignment Submission')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('assignment.index') }}">Assignment</a></li>
    <li class="breadcrumb-item">Submission</li>
</ul>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between align-center">
                    <h1 class="card-title">{{ $assignment->title }}</h1>
                    <div class="card-setting d-flex gap-1">
                        <a class="text-danger" title="Back" href="{{ route('assignment.index') }}"><span class="fa fa-arrow-left"></span></a>
                    </div>
                </div>
                <div class="card-body expand">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Student</th>
                                <th>Submission Date</th>
                                <th>Checked</th>
                                <th>Grade</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assignment->submissions as $key => $submission)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $submission->student->user->name }}</td>
                                <td>{{ $submission->submission_date }}</td>
                                <td>
                                    @if($submission->checked == 1)
                                    <span class="text-success">Checked</span>
                                    @else
                                    <span class="text-danger">Unchecked</span>
                                    @endif
                                </td>
                                <td>{{ $submission->grade ?? 'N/A' }}</td>
                                <td>{{ $submission->remarks ?? 'N/A' }}</td>
                                <td>
                                    <a class="text-primary" title="View Submission" href="{{ route('assignment.submission.show', ['key' => $assignment->key, 'student_key' => $submission->student->user->key]) }}"><span class="fa fa-eye"></span></a>
                                    @if(auth()->user()->can('check-assignment-submission.create') && $submission->checked == 0)
                                    <a class="text-warning ml-1" title="Check Assignment" href="{{ route('assignment.submission.check', ['key' => $assignment->key, 'student_key' => $submission->student->user->key]) }}"><span class="fa fa-check"></span></a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">No assignment submission found at this moment.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-specific-script')

@endsection