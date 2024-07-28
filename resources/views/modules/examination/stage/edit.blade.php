@extends('layouts.app')

@section('title', 'Update Examination Stage')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('examination.stage.index') }}">Examination Stage</a></li>
    <li class="breadcrumb-item">Update</li>
</ul>
@endsection

@section('content')
<div class="container">
    <form action="{{ route('examination.stage.update', $examinationStage->key) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex-space-between">
                        <h1 class="card-title">Update Examination Stage</h1>
                        <div class="card-setting d-flex gap-2">
                            <a class="text-danger" href="{{ route('examination.stage.index') }}"><span class="fa fa-arrow-left"></span></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input id="name" class="form-control" type="text" name="name" placeholder="Name" value="{{ $examinationStage->name }}">
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="academicYear">Academic Year <span class="text-danger">*</span></label>
                                    <select class="form-control" name="academic_year" id="academicYear"  data-init-plugin="select2">
                                        <option value="" selected disabled>Select Academic Year</option>
                                        @forelse($academicYears as $academicYear)
                                        <option value="{{ $academicYear->id }}" @if($examinationStage->academic_year_id == $academicYear->id) selected @endif>{{ $academicYear->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('academic_year')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="program">Program <span class="text-danger">*</span></label>
                                    <select class="form-control" name="program" id="program"  data-init-plugin="select2" data-semesters="{{ $semesters }}">
                                        <option value="" selected disabled>Select program</option>
                                        @forelse($programs as $program)
                                        <option value="{{ $program->id }}" @if($examinationStage->program_id == $program->id) selected @endif>{{ $program->name }}</option>
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
                                    <label for="semester">Semester <span class="text-danger">*</span></label>
                                    <select class="form-control" name="semester" id="semester"  data-init-plugin="select2" data-semesterId="{{ $examinationStage->semester_id }}" data-sessions="{{ $sessions }}">
                                        <option value="" selected disabled>Select semester</option>
                                    </select>
                                    @error('semester')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="session">Session <span class="text-danger">*</span></label>
                                    <select class="form-control" name="session" id="session"  data-init-plugin="select2" data-sessionId="{{ $examinationStage->session_id }}">
                                        <option value="" selected disabled>Select session</option>
                                    </select>
                                    @error('session')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="start_date">Start Date <span class="text-danger">*</span></label>
                                    <input id="start_date" class="form-control" type="date" name="start_date" value="{{ $examinationStage->start_date }}" min="{{ now()->format('Y-m-d') }}">
                                    @error('start_date')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="end_date">End Date <span class="text-danger">*</span></label>
                                    <input id="end_date" class="form-control" type="date" name="end_date" value="{{ $examinationStage->end_date }}" min="{{ now()->format('Y-m-d') }}">
                                    @error('end_date')
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

        $('#academicYear').on('change', function() {
            updateSessionOptions();
        });

        $('#program').on('change', function() {
            updateSemesterOptions();
        });

        $('#semester').on('change', function() {
            updateSessionOptions();
        });

        updateSemesterOptions();
        updateSessionOptions();
    });

    function updateSemesterOptions() {
        let semesters = $('#program').data('semesters');
        let programId = $('#program').val();
        let semesterId = $('#semester').data('semesterid')

        var filteredSemesters = semesters.filter(function(semester) {
            return semester.program.id == programId;
        });

        var content = '<option value="" selected disabled>Select semester</option>';

        var optionStrings = filteredSemesters.map(element => {
            return `<option value="${element.id}" ${element.id == semesterId ? 'selected' : ''}>${element.name}</option>`;
        });

        content += optionStrings.join('');
        $('#semester').html(content);
    }

    function updateSessionOptions() {
        let academicYearId = $('#academicYear').val();
        let sessions = $('#semester').data('sessions');
        let semesterId = $('#semester').val();
        let sessionId = $('#session').data('sessionid');

        var filteredSemesters = sessions.filter(function(session) {
            if (academicYearId) {
                return session.semester.id == semesterId && session.academic_year.id == academicYearId;
            }
            return session.semester.id == semesterId;
        });

        var content = '<option value="" selected disabled>Select session</option>';

        var optionStrings = filteredSemesters.map(element => {
            return `<option value="${element.id}" ${element.id == sessionId ? 'selected' : ''}>${element.name}</option>`;
        });

        content += optionStrings.join('');
        $('#session').html(content);
    }
</script>

@endsection