@extends('layouts.app')

@section('title', 'Check Assignment')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('assignment.index') }}">Assignment</a></li>
    <li class="breadcrumb-item"><a href="{{ route('assignment.submission.index', $submission->assignment->key) }}">Submission</a></li>
    <li class="breadcrumb-item">Check</li>
</ul>
@endsection

@section('content')
<div class="container">
    <form class="row" action="{{ route('assignment.submission.checking', ['key' => $submission->assignment->key, 'student_key' => $submission->student->user->key]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between align-center">
                    <h1 class="card-title">Assignment of {{ $submission->student->user->name }}</h1>
                    <div class="card-setting d-flex gap-1">
                        <a class="text-danger" title="Back" href="{{ route('assignment.submission.index', $submission->assignment->key) }}"><span class="fa fa-arrow-left"></span></a>
                    </div>
                </div>
                <div class="card-body expand">
                    <div class="row">
                        <div class="col-md-12">
                            <strong>{{ $submission->assignment->title }}</strong>
                            <div class="mt-2 mb-2">{!! $submission->assignment->description !!}</div>
                            <span class="fa fa-calendar"></span> Submission Date: {{ $submission->submission_date }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach($submission->assignment->questions as $key => $question)
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header d-flex-space-between align-center">
                    <h4>Question-{{ $key + 1 }}</h4>
                </div>
                <div class="card-body expand">
                    <div class="row">
                        <div class="col-md-12">
                            <strong>{{ $question->question }}</strong>
                            <div class="mt-2 mb-2">{!! $question->description !!}</div>
                        </div>
                        <div class="col-md-12">
                            <strong>Answer</strong>
                            <div class="d-flex-space-between gap-1">
                                @php
                                $answer = getAnswer($question, $submission->id);
                                $files = json_decode($answer->uploads) ?? [];
                                $extension = 'pdf';
                                @endphp
                                @if($question->answer_type == 'Writing')
                                {!! $answer->answer !!}
                                @else
                                @foreach($files as $file)
                                @if($extension == strtolower(pathinfo(storage_path($file), PATHINFO_EXTENSION)))
                                <a href="{{ asset('storage/assignment/'.$file) }}" target="_blank">
                                    <div class="card" style="height:100px; width:130px; border-radius:10px">
                                        <div class="card-body">
                                            <div class="text-center mt-5">
                                                <span class="semi-bold">View PDF</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                @else
                                <a href="{{ asset('storage/assignment/'.$file) }}" target="_blank"><img src="{{ asset('storage/assignment/'.$file) }}" height="100" width="130" style="border-radius: 10px;"></a>
                                @endif
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="grade-{{ $answer->id }}">Grade <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="grades[{{ $answer->id }}]" placeholder="Grade" value="{{ old('grades.'.$answer->id) }}">
                                @error('grades.' . $answer->id)
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="comment-{{ $answer->id }}">Comment</label>
                                <input class="form-control" type="text" name="comments[{{ $answer->id }}]" placeholder="Comment" value="{{ old('comments.'.$answer->id) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="overall-grade">Overall Grade <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="overall_grade" placeholder="Overall grade" value="{{ old('overall_grade') }}">
                                @error('overall_grade')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="remarks">Remarks</label>
                                <input class="form-control" type="text" name="remarks" placeholder="Remarks" value="{{ old('remarks') }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-md btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('page-specific-script')

@endsection