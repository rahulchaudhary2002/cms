@extends('layouts.app')

@section('title', 'Manage Student')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item">Student</li>
</ul>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between align-center">
                    <h1 class="card-title">Students List</h1>
                    <div class="card-setting d-flex gap-2">
                        @if(auth()->user()->can('student.create'))
                        <a class="btn btn-sm btn-outline-warning text-center btn-rounded" href="{{ route('student.create') }}"><span class="fa fa-plus"></span> create student</a>
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
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <select class="form-control" name="academic_year" id="academicYear" data-init-plugin="select2">
                                        <option value="">Select Academic Year</option>
                                        @forelse($academicYears as $academicYear)
                                        <option value="{{ $academicYear->key }}" @if(request()->get('academic_year') == $academicYear->key) selected @endif>{{ $academicYear->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <select class="form-control" name="program" id="program" data-init-plugin="select2" data-semesters="{{ $semesters }}">
                                        <option value="">Select program</option>
                                        @forelse($programs as $program)
                                        <option value="{{ $program->key }}" @if(request()->get('program') == $program->key) selected @endif>{{ $program->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <select class="form-control" name="semester" id="semester" data-init-plugin="select2" data-semesterKey="{{ request()->get('semester') }}" data-sessions="{{ $sessions }}">
                                        <option value="">Select semester</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <select class="form-control" name="session" id="session" data-init-plugin="select2" data-sessionKey="{{ request()->get('session') }}">
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
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Academic Year</th>
                                <th>Program</th>
                                <th>Semester</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($result->students as $key => $student)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->mobile }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->student->academicYear->name }}</td>
                                <td>{{ $student->student->program->name }}</td>
                                <td>{{ $student->student->semester->semester->name ?? 'N/A' }}</td>
                                <td>
                                    <a class="text-success mr-1" href="{{ route('student.show', $student->key) }}"><span class="fa fa-eye"></span></a>
                                    @if(auth()->user()->can('student.edit'))
                                    <a class="text-danger" title="Edit" href="{{ route('student.edit', $student->key) }}"><span class="fa fa-edit"></span></a>
                                    @endif
                                    @if(auth()->user()->can('assign-semester.create'))
                                    <a class="text-primary ml-1" title="Assign Semester" href="{{ route('semester.assign.create', $student->key) }}"><span class="fa fa-user-plus"></span></a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8">No student found at this moment.</td>
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
        let programKey = $('#program').val();
        let semesterKey = $('#semester').data('semesterkey')

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
        let academicYearKey = $('#academicYear').val();
        let sessions = $('#semester').data('sessions');
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
</script>

@endsection