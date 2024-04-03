@extends('layouts.app')

@section('title', 'Assign Course')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('user.index').'?role=teacher' }}">Teacher</a></li>
    <li class="breadcrumb-item"><a href="{{ route('course.index') }}">Course</a></li>
    <li class="breadcrumb-item">Assign</li>
</ul>
@endsection

@section('content')
<div class="container">
    <form action="{{ route('course.assign.store', $user->key) }}" method="POST">
        @csrf
        <input type="hidden" name="teacher" value="{{ $user->teacher->id }}">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex-space-between">
                        <h1 class="card-title">Assign Course</h1>
                        <div class="card-setting d-flex gap-2">
                            <a class="text-danger" href="{{ route('user.index').'?role=teacher' }}"><span class="fa fa-arrow-left"></span></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Teacher Name</label>
                                    <input id="name" class="form-control" type="text" name="name" placeholder="Name" value="{{ $user->name }}" readonly >
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="academic-year">Academic Year <span class="text-danger">*</span></label>
                                    <select class="form-control" name="academic_year" id="academic-year"  data-init-plugin="select2" data-sessions="{{ $sessions }}">
                                        <option value="" selected disabled>Select Academic Year</option>
                                        @forelse($academicYears as $academicYear)
                                        <option value="{{ $academicYear->id }}" @if($academicYear->id == old('academic_year')) selected @endif>{{ $academicYear->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('program')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="program">Program <span class="text-danger">*</span></label>
                                    <select class="form-control" name="program" id="program"  data-init-plugin="select2">
                                        <option value="">Select program</option>
                                        @forelse($programs as $program)
                                        <option value="{{ $program->id }}" @if($program->id == old('program')) selected @endif>{{ $program->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('program')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="session">Session <span class="text-danger">*</span></label>
                                    <select class="form-control" name="session" id="session"  data-init-plugin="select2" data-courses="{{ $courses }}">
                                        <option value="">Select session</option>
                                    </select>
                                    @error('session')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="course">Course <span class="text-danger">*</span></label>
                                    <select class="form-control" name="course" id="course"  data-init-plugin="select2">
                                        <option value="">Select course</option>
                                    </select>
                                    @error('course')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
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
</div>

@endsection

@section('page-specific-script')

<script>
    $(document).ready(function() {
        $('[data-init-plugin=select2]').select2();

        $('#academic-year').on('change', function() {
            updateSessionOptions();
            updateCourseOptions();
        });

        $('#program').on('change', function() {
            updateSessionOptions();
            updateCourseOptions();
        });

        $('#session').on('change', function() {
            updateCourseOptions();
        });

        updateSessionOptions();
        updateCourseOptions();
    });

    function updateSessionOptions() {
        var sessions = $('#academic-year').data('sessions');
        var academicYearId = $('#academic-year').val();
        var programId = $('#program').val();

        var filteredSessions = sessions.filter(function(session) {
            return session.academic_year.id == academicYearId && session.program.id == programId;
        });

        var content = '<option value="" selected disabled>Select session</option>';

        var optionStrings = filteredSessions.map(element => {
            return `<option value="${element.id}">${element.name}</option>`;
        });

        content += optionStrings.join('');
        $('#session').html(content);
    }

    function updateCourseOptions() {
        var sessionId = $('#session').val();
        var sessions = $('#academic-year').data('sessions');
        var courses = $('#session').data('courses');
        var filteredCourses = [];
        const session = sessions.find(item => item.id == sessionId);

        if (session) {
            filteredCourses = courses.filter(function(course) {
                return course.semester_id == session.semester_id;
            });
        }

        var content = '<option value="" selected disabled>Select course</option>';

        var optionStrings = filteredCourses.map(element => {
            return `<option value="${element.id}">${element.name}</option>`;
        });

        content += optionStrings.join('');
        $('#course').html(content);
    }
</script>

@endsection