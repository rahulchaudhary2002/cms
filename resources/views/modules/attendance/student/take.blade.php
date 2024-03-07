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
                        <a class="text-danger" href="{{ route('student.attendance.index') }}"><span class="fa fa-arrow-left"></span></a>
                    </div>
                </div>
                <div class="card-body expand">
                    <form action="{{ url()->current() }}" id="search-attendance-form" method="GET">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="academicYear">Acacemic Year <span class="text-danger">*</span></label>
                                    <select class="form-control" name="academic_year" id="academicYear"  data-init-plugin="select2">
                                        <option value="" selected disabled>Select Academic Year</option>
                                        @forelse($academicYears as $academicYear)
                                        <option value="{{ $academicYear->key }}" @if(request()->get('academic_year') == $academicYear->key) selected @endif>{{ $academicYear->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="program">Program <span class="text-danger">*</span></label>
                                    <select class="form-control" name="program" id="program"  data-init-plugin="select2" data-semesters="{{ $semesters }}">
                                        <option value="" selected disabled>Select program</option>
                                        @forelse($programs as $program)
                                        <option value="{{ $program->key }}" @if(request()->get('program') == $program->key) selected @endif>{{ $program->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="semester">Semester <span class="text-danger">*</span></label>
                                    <select class="form-control" name="semester" id="semester"  data-init-plugin="select2" data-semesterKey="{{ request()->get('semester') }}" data-sessions="{{ $sessions }}" data-courses="{{ $courses }}">
                                        <option value="" selected disabled>Select semester</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="session">Session <span class="text-danger">*</span></label>
                                    <select class="form-control" name="session" id="session"  data-init-plugin="select2" data-sessionKey="{{ request()->get('session') }}">
                                        <option value="" selected disabled>Select session</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="course">Course <span class="text-danger">*</span></label>
                                    <select class="form-control" name="course" id="course"  data-init-plugin="select2" data-courseKey="{{ request()->get('course') }}">
                                        <option value="" selected disabled>Select course</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="date">Date <span class="text-danger">*</span></label>
                                    <input class="form-control" type="date" name="date" id="date" value="{{ request()->get('date') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-md btn-warning">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @if($result)
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between align-center">
                    <h1 class="card-title">Take Attendance</h1>
                </div>
                <div class="card-body expand">
                    <form action="{{ route('student.attendance.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="course" value="{{ $result->course->id }}">
                        <input type="hidden" name="date" value="{{ $result->date }}">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Name</th>
                                    <th>Present</th>
                                    <th>Absent</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($result->students as $key => $student)
                                <input type="hidden" name="students[]" value="{{ $student->student->id }}">
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td><input type="radio" name="status[{{ $student->student->id }}]" value="present" checked></td>
                                    <td><input type="radio" name="status[{{ $student->student->id }}]" value="absent"></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">No student found at this moment.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <button class="btn btn-md btn-warning mt-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@section('page-specific-script')

<script>
    $(document).ready(function() {
        $('[data-init-plugin=select2]').select2();

        $('#academicYear').on('change', function() {
            updateSessionOptions();
        });

        $('#program').on('change', function() {
            updateSemesterOptions();
        });

        $('#semester').on('change', function() {
            updateSessionOptions();
            updateCourseOptions();
        });

        $('#session').on('change', function() {
            updateCourseOptions();
        });

        updateSemesterOptions();
        updateSessionOptions();
        updateCourseOptions();
    });

    function updateSemesterOptions() {
        let semesters = $('#program').data('semesters');
        let programKey = $('#program').val();
        let semesterKey = $('#semester').data('semesterkey')

        var filteredSemesters = semesters.filter(function(semester) {
            return semester.program.key == programKey;
        });

        var content = '<option value="" selected disabled>Select semester</option>';

        var optionStrings = filteredSemesters.map(element => {
            return `<option value="${element.key}" ${element.key == semesterKey ? 'selected' : ''}>${element.name}</option>`;
        });

        content += optionStrings.join('');
        $('#semester').html(content);
    }

    function updateSessionOptions() {
        let academicYearKey = $('#academicYear').val();
        let sessions = $('#semester').data('sessions');
        let semesterKey = $('#semester').val();
        let sessionKey = $('#session').data('sessionkey');

        var filteredSessions = sessions.filter(function(session) {
            if (academicYearKey) {
                return session.semester.key == semesterKey && session.academic_year.key == academicYearKey;
            }
            return session.semester.key == semesterKey;
        });

        var content = '<option value="" selected disabled>Select session</option>';

        var optionStrings = filteredSessions.map(element => {
            return `<option value="${element.key}" ${element.key == sessionKey ? 'selected' : ''}>${element.name}</option>`;
        });

        content += optionStrings.join('');
        $('#session').html(content);
    }

    function updateCourseOptions() {
        let courses = $('#semester').data('courses');
        let semesterKey = $('#semester').val();
        let courseKey = $('#course').data('coursekey');
        let sessionKey = $('#session').val();
        var superadmin = "{{ auth()->user()->hasRole('superadmin') }}";
        var teacher = "{{ auth()->user()->hasRole('teacher') }}";

        var filteredCourses = courses.filter(function(course) {
            if (superadmin) {
                return course.semester.key == semesterKey;
            }

            if (teacher && sessionKey) {
                var filteredTeacherCourses = course.teacher_courses.filter(function(teacherCourse) {
                    return teacherCourse.session.key == sessionKey;
                });

                if (filteredTeacherCourses.length > 0) {
                    return course.semester.key == semesterKey && filteredTeacherCourses[0].course_id == course.id;
                } else {
                    return false;
                }
            }

            return course.semester.key == semesterKey;
        });

        var content = '<option value="" selected disabled>Select course</option>';

        var optionStrings = filteredCourses.map(element => {
            return `<option value="${element.key}" ${element.key == courseKey ? 'selected' : ''}>${element.name}</option>`;
        });

        content += optionStrings.join('');
        $('#course').html(content);
    }
</script>

@endsection