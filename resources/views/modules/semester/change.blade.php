@extends('layouts.app')

@section('title', 'Change Semester')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item">Change Semester</li>
</ul>
@endsection

@section('content')
<div class="container">
    @if(!$session || ($user->student->semester && $user->student->semester->session_id == $session->id))
    <div class="card">
        <div class="card-body">
            <span class="text-warning">Next semester form is not opened yet.</span>
        </div>
    </div>
    @else
    <form action="{{ route('semester.change.update', $user->key) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex-space-between">
                        <h1 class="card-title">Change Semester</h1>
                        <div class="card-setting d-flex gap-2">
                            <a class="text-danger" href="{{ route('dashboard') }}"><span class="fa fa-arrow-left"></span></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mt-2 mb-2">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Student Name</label>
                                    <input id="name" class="form-control" type="text" name="name" placeholder="Name" value="{{ $user->name }}" readonly >
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="program">Program</label>
                                    <select class="form-control" name="program" id="program"  data-init-plugin="select2">
                                        <option value="{{ $user->student->program->id }}">{{ $user->student->program->name }}</option>
                                    </select>
                                    @error('program')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="semester">Semester</label>
                                    <select class="form-control" name="semester" id="semester"  data-init-plugin="select2">
                                        <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                                    </select>
                                    @error('semester')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="session">Session</label>
                                    <select class="form-control" name="session" id="session"  data-init-plugin="select2">
                                        <option value="{{ $session->id }}">{{ $session->name }}</option>
                                    </select>
                                    @error('session')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Courses <span class="text-danger">*</span></label>
                                    <div class="row mt-2">
                                        @foreach($semester->compulsoryCourses as $key => $course)
                                        <div class="col-md-4 col-sm-12 checkbox">
                                            <input class="check-course" type="checkbox" name="courses[]" value="{{ $course->id }}" id="course-{{ $key }}" checked disabled>
                                            <label for="course-{{ $key }}">{{ $course->name }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                    @error('courses')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @if($semester->number_of_elective_courses > 0)
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Elective Courses <span class="text-danger">*</span> <span class="text-warning">(Choose {{ $semester->number_of_elective_courses }} elective courses)</span></label>
                                    <div class="row mt-2">
                                        @foreach($semester->electiveCourses as $key => $course)
                                        <div class="col-md-4 col-sm-12 checkbox">
                                            <input class="check-elective-course" type="checkbox" name="elective_courses[]" value="{{ $course->id }}" id="elective-course-{{ $key }}">
                                            <label for="elective-course-{{ $key }}">{{ $course->name }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                    @error('elective_courses')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @endif
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-md btn-primary">Submit</button>
                                <button type="reset" class="btn btn-md btn-warning">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endif
</div>
@endsection

@section('page-specific-script')

<script>
    $(document).ready(function() {
        var number_of_elective_courses = '{{ $semester->number_of_elective_courses }}';

        $('body').on('change', '.check-elective-course', function() {
            totalcoursecheckboxchecked = $('input.check-elective-course:checkbox:checked').length;

            if (totalcoursecheckboxchecked > number_of_elective_courses) {
                $(this).prop('checked', false);
            }

            totalcoursecheckboxchecked = $('input.check-elective-course:checkbox:checked').length;
        })
    });
</script>

@endsection