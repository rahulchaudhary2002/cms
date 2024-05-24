@extends('layouts.app')

@section('title', 'Show Examination Record')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('examination.stage.index') }}">Examination Record</a></li>
    <li class="breadcrumb-item">Show</li>
</ul>
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between align-center">
                    <h1 class="card-title">Marks</h1>
                    <div class="card-setting d-flex gap-2">
                        <a class="text-danger" href="{{ route('examination.record.index') }}"><span class="fa fa-arrow-left"></span></a>
                    </div>
                </div>
                <div class="card-body expand">
                    <div class="mb-3"><strong>Student Name: {{ $record->student->user->name }}</strong></div>
                    <div class="mb-3"><strong>Stage: {{ $record->examinationStage->name }}</strong></div>
                    <div class="mb-3"><strong>Program: {{ $record->examinationStage->program->name }}</strong></div>
                    <div class="mb-3"><strong>Semester: {{ $record->examinationStage->semester->name }}</strong></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Course</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($record->marks as $key => $value)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $value->course->name }}</td>
                                <td>{{ $value->grade }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">No record found at this moment.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3"><strong>GPA: {{ $record->gpa }}</strong></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection