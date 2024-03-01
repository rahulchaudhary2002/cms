@extends('layouts.app')

@section('title', 'Create Course')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('course.index') }}">Course</a></li>
    <li class="breadcrumb-item">Create</li>
</ul>
@endsection

@section('content')
<div class="container">
    <form action="{{ route('course.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex-space-between">
                        <h1 class="card-title">Create Course</h1>
                        <div class="card-setting d-flex gap-2">
                            <a class="text-danger" href="{{ route('course.index') }}"><span class="fa fa-arrow-left"></span></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mt-2 mb-2">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input id="name" class="form-control" type="text" name="name" placeholder="Name" >
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="course-code">Course Code <span class="text-danger">*</span></label>
                                    <input id="course-code" class="form-control" type="text" name="course_code" placeholder="Course Code" >
                                    @error('course_code')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="credit">Credit <span class="text-danger">*</span></label>
                                    <input id="credit" class="form-control" type="number" name="credit" placeholder="Credit" >
                                    @error('credit')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="program">Program <span class="text-danger">*</span></label>
                                    <select class="form-control" name="program" id="program"  data-init-plugin="select2" data-semesters="{{ $semesters }}">
                                        <option value="" selected disabled>Select program</option>
                                        @foreach($programs as $program)
                                        <option value="{{ $program->id }}">{{ $program->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('program')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="semester">Semester <span class="text-danger">*</span></label>
                                    <select class="form-control" name="semester" id="semester"  data-init-plugin="select2">
                                        <option value="" selected disabled>Select semester</option>
                                    </select>
                                    @error('semester')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="checkbox mt-2 mb-2">
                                        <input type="checkbox" id="check-elective" name="elective" value="1">
                                        <label for="check-elective">Elective</label>
                                    </div>
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

        $('body').on('change', '#program', function() {
            var semesters = $(this).data('semesters');
            let programId = parseInt($(this).val());

            var filteredSemesters = filterSemestersByProgramId(semesters, programId);
            
            var content = '<option value="" selected disabled>Select semester</option>';
            
            var optionStrings = filteredSemesters.map(element => {
                return `<option value="${element.id}">${ element.name }</option>`    
            });

            content += optionStrings.join('');
            $('#semester').html(content);
        });
    })

    function filterSemestersByProgramId(semesters, programId) {
        return semesters.filter(function(semester) {
            return semester.program_id === programId;
        });
    }
</script>

@endsection