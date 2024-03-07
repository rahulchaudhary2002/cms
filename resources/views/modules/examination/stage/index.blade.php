@extends('layouts.app')

@section('title', 'Manage Session')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item">Examination Stage</li>
</ul>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between align-center">
                    <h1 class="card-title">Examination Stages List</h1>
                    <div class="card-setting d-flex gap-2">
                        @if(auth()->user()->can('examination-stage.create'))
                        <a class="btn btn-sm btn-outline-warning text-center btn-rounded" href="{{ route('examination.stage.create') }}"><span class="fa fa-plus"></span> create examination stage</a>
                        @endif
                    </div>
                </div>
                <div class="card-body expand">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ request()->get('name') }}">
                                </div>
                            </div>
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
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <select class="form-control" name="semester" id="semester"  data-init-plugin="select2" data-semesters="{{ $semesters }}" data-semesterKey="{{ request()->get('semester') }}">
                                        <option value="">Select semester</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <select class="form-control" name="session" id="session"  data-init-plugin="select2" data-sessions="{{ $sessions }}" data-sessionKey="{{ request()->get('session') }}">
                                        <option value="">Select session</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
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
                                <th>Name</th>
                                <th>Academic Year</th>
                                <th>Program</th>
                                <th>Semester</th>
                                <th>Session</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($result->examinationStages as $key => $examinationStage)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $examinationStage->name }}</td>
                                <td>{{ $examinationStage->academicYear->name }}</td>
                                <td>{{ $examinationStage->program->name }}</td>
                                <td>{{ $examinationStage->semester->name }}</td>
                                <td>{{ $examinationStage->session->name }}</td>
                                <td>
                                    @if(auth()->user()->can('examination-stage.edit'))
                                    <a class="text-danger" href="{{ route('examination.stage.edit', $examinationStage->key) }}"><span class="fa fa-edit"></span></a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">No examination stage found at this moment.</td>
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
        });

        $('#semester').on('change', function() {
            updateSessionOptions();
        });

        updateSemesterOptions();
        updateSessionOptions();
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
</script>

@endsection