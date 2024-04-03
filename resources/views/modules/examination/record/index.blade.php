@extends('layouts.app')

@section('title', 'Manage Examination Records')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item">Examination Records</li>
</ul>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between align-center">
                    <h1 class="card-title">Search Students</h1>
                    {{--<div class="card-setting d-flex gap-2">
                        @if(auth()->user()->can('examination-record.create'))
                        <a class="btn btn-sm btn-outline-warning text-center btn-rounded" href="{{ route('examination.record.create') }}"><span class="fa fa-plus"></span> create examination record</a>
                    @endif
                </div>--}}
            </div>
            <div class="card-body expand">
                <form action="{{ url()->current() }}" method="GET">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="academicYear">Academic Year <span class="text-danger">*</span></label>
                                <select class="form-control" name="academic_year" id="academicYear" data-init-plugin="select2">
                                    <option value="">Select Academic Year</option>
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
                                <select class="form-control" name="program" id="program" data-init-plugin="select2">
                                    <option value="">Select program</option>
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
                                <select class="form-control" name="semester" id="semester" data-init-plugin="select2" data-semesters="{{ $semesters }}" data-semesterKey="{{ request()->get('semester') }}">
                                    <option value="">Select semester</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="session">Session <span class="text-danger">*</span></label>
                                <select class="form-control" name="session" id="session" data-init-plugin="select2" data-sessions="{{ $sessions }}" data-sessionKey="{{ request()->get('session') }}">
                                    <option value="">Select session</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="examination-stage">Examination Stage <span class="text-danger">*</span></label>
                                <select class="form-control" name="examination_stage" id="examination-stage" data-init-plugin="select2">
                                    <option value="">Select examination stage</option>
                                </select>
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
            <div class="card-header">
                <h1 class="card-title">Students</h1>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>GPA</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($result->students as $key => $student)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ examinationRecord($student, request()->get('examination_stage'))->gpa ?? "N/A" }}</td>
                            <td>
                                <a class="text-success mr-1" title="View Examination Record" href="{{ route('examination.record.show', [request()->get('examination_stage'), $student->key]) }}"><span class="fa fa-eye"></span></a>
                                @if(auth()->user()->can('examination-record.update'))
                                <a class="text-danger mr-1" title="Edit Examination Record" href="{{ route('examination.record.edit', [request()->get('examination_stage'), $student->key]) }}"><span class="fa fa-edit"></span></a>
                                @endif
                                @if(auth()->user()->can('examination-record.create'))
                                <a class="text-primary" title="Add Examination Record" href="{{ route('examination.record.create', [request()->get('examination_stage'), $student->key]) }}"><span class="fa fa-user-plus"></span></a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">No student found at this moment.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @include('includes.pagination', ['current' => $result->currentPage ?? 1, 'total' => $result->totalRecords > 0 ? $result->totalRecords : 1, 'length' => $result->recordsPerPage ?? 10, 'size' => $result->paginationSize ?? 2])
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
            updateExaminationStageOptions();
        });

        $('#program').on('change', function() {
            updateSemesterOptions();
            updateExaminationStageOptions();
        });

        $('#semester').on('change', function() {
            updateSessionOptions();
            updateExaminationStageOptions();
        });

        $('#session').on('change', function() {
            updateExaminationStageOptions();
        });

        updateSemesterOptions();
        updateSessionOptions();
        updateExaminationStageOptions();
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
        if (isStudent != 1) {
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

    function updateExaminationStageOptions() {
        let academicYearKey = $('#academicYear').val();
        let programKey = $('#program').val();
        let semesterKey = $('#semester').val();
        let sessionKey = $('#session').val();
        let examinationStages = "{{ json_encode($examinationStages) }}";
        examinationStages = JSON.parse(examinationStages.replace(/&quot;/g, '"'));
        let examinationStageKey = "{{ json_encode(request()->get('examination_stage')) }}";
        examinationStageKey = JSON.parse(examinationStageKey.replace(/&quot;/g, '"'));
        var filteredExaminationStages = [];

        if (examinationStages) {
            var filteredExaminationStages = examinationStages.filter(function(examinationStage) {
                return examinationStage.academic_year.key == academicYearKey && examinationStage.program.key == programKey && examinationStage.semester.key == semesterKey && examinationStage.session.key == sessionKey;
            });
        }

        var content = '<option value="">Select examination stage</option>';

        var optionStrings = filteredExaminationStages.map(element => {
            return `<option value="${element.key}" ${element.key == examinationStageKey ? 'selected' : ''}>${element.name}</option>`;
        });

        content += optionStrings.join('');
        $('#examination-stage').html(content);
    }
</script>

@endsection