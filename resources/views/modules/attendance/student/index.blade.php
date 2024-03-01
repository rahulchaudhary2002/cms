@extends('layouts.app')

@section('title', 'Manage Attendance')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item">Attendance</li>
</ul>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between align-center">
                    <h1 class="card-title">Search Attendance</h1>
                    <div class="card-setting d-flex gap-2">
                        @if(auth()->user()->can('student-attendance.create'))
                        <a class="btn btn-sm btn-outline-warning text-center btn-rounded" href="{{ route('student.attendance.take') }}"><span class="fa fa-plus"></span> take attendance</a>
                        @endif
                    </div>
                </div>
                <div class="card-body expand">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row">
                            @if(!auth()->user()->hasRole('student'))
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="academicYear">Acacemic Year <span class="text-danger">*</span></label>
                                    <select class="form-control" name="academic_year" id="academicYear"  data-init-plugin="select2">
                                        <option value="">Select Academic Year</option>
                                        @forelse($academicYears as $academicYear)
                                        <option value="{{ $academicYear->key }}" @if(request()->get('academic_year') == $academicYear->key) selected @endif>{{ $academicYear->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="program">Program <span class="text-danger">*</span></label>
                                    <select class="form-control" name="program" id="program"  data-init-plugin="select2">
                                        <option value="">Select program</option>
                                        @forelse($programs as $program)
                                        <option value="{{ $program->key }}" @if(request()->get('program') == $program->key) selected @endif>{{ $program->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            @else
                            <input type="hidden" name="academic_year" value="{{ auth()->user()->student->academicYear->key }}">
                            <input type="hidden" name="program" value="{{ auth()->user()->student->program->key }}">
                            @endif
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="semester">Semester <span class="text-danger">*</span></label>
                                    <select class="form-control" name="semester" id="semester"  data-init-plugin="select2" data-semesters="{{ $semesters }}" data-semesterKey="{{ request()->get('semester') }}">
                                        <option value="">Select semester</option>
                                    </select>
                                </div>
                            </div>
                            @if(!auth()->user()->hasRole('student'))
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="session">Session <span class="text-danger">*</span></label>
                                    <select class="form-control" name="session" id="session"  data-init-plugin="select2" data-sessions="{{ $sessions }}" data-sessionKey="{{ request()->get('session') }}">
                                        <option value="">Select session</option>
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="course">Course <span class="text-danger">*</span></label>
                                    <select class="form-control" name="course" id="course"  data-init-plugin="select2" data-courses="{{ $courses }}" data-courseKey="{{ request()->get('course') }}">
                                        <option value="">Select course</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="date">Date <span class="text-danger">*</span></label>
                                    <input class="form-control" type="month" name="date" id="date" value="{{ request()->get('date') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group btn-mt-1">
                                    <button class="btn btn-md btn-primary"><i class="fa fa-search"></i> Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @if($result)
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between">
                    <h1 class="card-title">Attendance Sheet of {{ $result->program->name }} ({{ $result->academicYear->name }}) : {{ Carbon\Carbon::createFromFormat('Y-m', $result->date)->monthName }} {{ Carbon\Carbon::createFromFormat('Y-m', $result->date)->year }}</h1>
                </div>
                <div class="card-body expand">
                    <table class="table attendance-table">
                        @if($attendances)
                        <thead>
                            <tr>
                                <th><span><span class="fa fa-arrow-down"></span> Name</span><span class="pull-right">Date <span class="fa fa-arrow-right"></span></span></th>
                                @for($i = 1; $i <= $days; $i++) <th>{{ $i }}</th>
                                    @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($result->students as $student)
                            <tr>
                                <td>{{ $student->name }}</td>
                                @for($i = 1; $i <= $days; $i++) <td>
                                    @php
                                    $attendanceForDate = $attendances
                                    ->where('date', Carbon\Carbon::createFromFormat('Y-m-d', $result->date.'-'.$i)->format('Y-m-d'))
                                    ->where('student_id', $student->student->id)
                                    ->first();
                                    @endphp

                                    @if($attendanceForDate && $attendanceForDate->status == 'present')
                                    <span class="fa fa-check text-success"></span>
                                    @elseif($attendanceForDate && $attendanceForDate->status == 'absent')
                                    <span class="fa fa-xmark text-danger"></span>
                                    @else
                                    @endif
                                    </td>
                                    @endfor
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                        @else
                        <td>No result found at the moment! Make sure that you have taken attendance in {{ Carbon\Carbon::createFromFormat('Y-m', $result->date)->monthName }} {{ Carbon\Carbon::createFromFormat('Y-m', $result->date)->year }}</td>
                        @endif
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@section('page-specific-script')

<script>
    var isStudent = "{{ auth()->user()->hasRole('student') }}";
    
    $(document).ready(function() {
        $('[data-init-plugin=select2]').select2();

        $('#academicYear').on('change', function() {
            updateSessionOptions();
        });

        $('#program').on('change', function() {
            updateSemesterOptions();
            updateCourseOptions();
        });

        $('#semester').on('change', function() {
            updateSessionOptions();
            updateCourseOptions();
        });

        updateSemesterOptions();
        updateSessionOptions();
        updateCourseOptions();
    });

    function updateSemesterOptions() {
        let semesters = $('#semester').data('semesters');
        let programKey = isStudent == 1 ? '{{ auth()->user()->student ? auth()->user()->student->program->key : "" }}' : $('#program').val();
        let semesterKey = $('#semester').data('semesterkey');

        var filteredSemesters = semesters.filter(function(semester) {
            return semester.program.key == programKey;
        });

        var content = '<option value="">Select semester</option>';

        var optionStrings = filteredSemesters.map(element => {
            return `<option value="${element.key}" ${element.key == semesterKey ? 'selected' : ''}>${element.name}</option>`;
        });

        content += optionStrings.join('');
        $('#semester').html(content);
    }

    function updateSessionOptions() {
        if(isStudent != 1) {
            let academicYearKey = $('#academicYear').val();
            let sessions = $('#session').data('sessions');
            let semesterKey = $('#semester').val();
            let sessionKey = $('#session').data('sessionkey');
    
            var filteredSemesters = sessions.filter(function(session) {
                if (academicYearKey) {
                    return session.semester.key == semesterKey && session.academic_year.key == academicYearKey;
                }
                return session.semester.key == semesterKey;
            });
    
            var content = '<option value="">Select session</option>';
    
            var optionStrings = filteredSemesters.map(element => {
                return `<option value="${element.key}" ${element.key == sessionKey ? 'selected' : ''}>${element.name}</option>`;
            });
    
            content += optionStrings.join('');
            $('#session').html(content);
        }
    }

    function updateCourseOptions() {
        let courses = $('#course').data('courses');
        let semesterKey = $('#semester').val();
        let courseKey = $('#course').data('coursekey');

        var filteredCourses = courses.filter(function(course) {
            return course.semester.key == semesterKey;
        });

        var content = '<option value="">Select course</option>';

        var optionStrings = filteredCourses.map(element => {
            return `<option value="${element.key}" ${element.key == courseKey ? 'selected' : ''}>${element.name}</option>`;
        });

        content += optionStrings.join('');
        $('#course').html(content);
    }
</script>

@endsection