@extends('layouts.app')

@section('title', 'Manage Course')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item">Course</li>
</ul>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between align-center">
                    <h1 class="card-title">Courses List</h1>
                    <div class="card-setting d-flex gap-2">
                        @if(auth()->user()->can('course.create'))
                        <a class="btn btn-sm btn-outline-warning text-center btn-rounded" href="{{ route('course.create') }}"><span class="fa fa-plus"></span> create course</a>
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
                                    <select class="form-control" name="program" id="program"  data-init-plugin="select2" data-semesters="{{ $semesters }}">
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
                                    <select class="form-control" name="semester" id="semester"  data-init-plugin="select2" data-semesterKey="{{ request()->get('semester') }}">
                                        <option value="">Select semester</option>
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
                                <th>Course Code</th>
                                <th>Credit</th>
                                <th>Semester</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($result->courses as $key => $course)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $course->name }}</td>
                                <td>{{ $course->course_code }}</td>
                                <td>{{ $course->credit }}</td>
                                <td>{{ $course->semester->name ?? '' }}</td>
                                <td>
                                    @if($course->elective == 1)
                                    <span class="text-danger">Elective</span>
                                    @else
                                    <span class="text-success">Compulsory</span>
                                    @endif
                                </td>
                                <td>
                                    @if(auth()->user()->can('course.edit'))
                                    <a class="text-warning" href="{{ route('course.edit', $course->key) }}"><span class="fa fa-edit"></span></a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">No course found at this moment.</td>
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

        $('#program').on('change', function() {
            updateSemesterOptions();
        });

        updateSemesterOptions();
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
</script>

@endsection