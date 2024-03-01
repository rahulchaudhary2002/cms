@extends('layouts.app')

@section('title', 'Manage Assignment')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item">Assignment</li>
</ul>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between align-center">
                    <h1 class="card-title">Assignment List</h1>
                    <div class="card-setting d-flex gap-2">
                        @if(auth()->user()->can('assignment.create'))
                        <a class="btn btn-sm btn-outline-warning text-center btn-rounded" href="{{ route('assignment.create') }}"><span class="fa fa-plus"></span> create assignment</a>
                        @endif
                    </div>
                </div>
                <div class="card-body expand">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="{{ request()->get('title') }}">
                                </div>
                            </div>
                            @if(!auth()->user()->hasRole('student'))
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <select class="form-control" name="academic_year" id="academicYear"  data-init-plugin="select2">
                                        <option value="">Select Academic Year</option>
                                        @forelse($academicYears as $academicYear)
                                        <option value="{{ $academicYear->key }}" @if(request()->get('academic_year') == $academicYear->key) selected @endif>{{ $academicYear->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <select class="form-control" name="program" id="program"  data-init-plugin="select2">
                                        <option value="">Select program</option>
                                        @forelse($programs as $program)
                                        <option value="{{ $program->key }}" @if(request()->get('program') == $program->key) selected @endif>{{ $program->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <select class="form-control" name="semester" id="semester"  data-init-plugin="select2" data-semesters="{{ $semesters }}" data-semesterKey="{{ request()->get('semester') }}">
                                        <option value="">Select semester</option>
                                    </select>
                                </div>
                            </div>
                            @if(!auth()->user()->hasRole('student'))
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <select class="form-control" name="session" id="session"  data-init-plugin="select2" data-sessions="{{ $sessions }}" data-sessionKey="{{ request()->get('session') }}">
                                        <option value="">Select session</option>
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <select class="form-control" name="course" id="course"  data-init-plugin="select2" data-courses="{{ $courses }}" data-courseKey="{{ request()->get('course') }}">
                                        <option value="">Select course</option>
                                    </select>
                                </div>
                            </div>
                            @if(auth()->user()->hasRole('student'))
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <select class="form-control" name="type" id="type"  data-init-plugin="select2">
                                        <option value="">Select type</option>
                                        <option value="submitted" @if(request()->get('type') == 'submitted') selected @endif>Submitted</option>
                                        <option value="unsubmitted" @if(request()->get('type') == 'unsubmitted') selected @endif>Unsubmitted</option>
                                        <option value="expired" @if(request()->get('type') == 'expired') selected @endif>Expired</option>
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group btn-mt-1">
                                    <button class="btn btn-md btn-primary"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Title</th>
                                <th>Submission Date</th>
                                <th>Submissions</th>
                                <th>Late Submission</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($result->assignments as $key => $assignment)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $assignment->title }}</td>
                                <td>{{ $assignment->submission_date }}</td>
                                <td>
                                    @if(auth()->user()->hasRole('student'))
                                    @if($assignment->authSubmission)
                                    <a title="View Submission" href="{{ route('assignment.submission.show', ['key' => $assignment->key, 'student_key' => auth()->user()->key]) }}">Submitted</a>
                                    @elseif($assignment->submission_date < now()->format('Y-m-d') && $assignment->late_submission == 0 && !$assignment->authSubmission)
                                    <span class="text-danger">Expired</span>
                                    @else
                                    <span class="text-warning">Unsubmitted</span>
                                    @endif
                                    @else
                                    <a title="View Submissions" href="{{ route('assignment.submission.index', $assignment->key) }}">{{ count($assignment->submissions) }} / {{ countAssignmentStudents($assignment) }}</a>
                                    @endif
                                </td>
                                <td>
                                    @if($assignment->late_submission == 1)
                                    <span class="text-success">Allow</span>
                                    @else
                                    <span class="text-danger">Deny</span>
                                    @endif
                                </td>
                                <td>{{ $assignment->creater->name }}</td>
                                <td>
                                    @if(auth()->user()->can('assignment.view'))
                                    <a class="text-primary mr-1" title="View Assignment" href="{{ route('assignment.show', $assignment->key) }}"><span class="fa fa-eye"></span></a>
                                    @endif
                                    @if(count($assignment->submissions) == 0 && auth()->user()->can('assignment.update'))
                                    <a class="text-warning mr-1" title="Edit Assignment" href="{{ route('assignment.edit', $assignment->key) }}"><span class="fa fa-edit"></span></a>
                                    @endif
                                    @if(auth()->user()->hasRole('student'))
                                    @if(($assignment->submission_date >= now()->format('Y-m-d') || $assignment->late_submission == 1) && !$assignment->authSubmission)
                                    <a class="text-success" title="Start Submission" href="{{ route('assignment.submission.create', $assignment->key) }}"><span class="fa fa-paper-plane"></span></a>
                                    @endif
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">No assignment found at this moment.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @include('includes.pagination', ['current' => $result->currentPage ?? 1, 'total' => $result->totalRecords > 0 ? $result->totalRecords : 1, 'length' => $result->recordsPerPage ?? 10, 'size' => $result->paginationSize ?? 2])
                </div>
            </div>
        </div>
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