@extends('layouts.app')

@section('title', 'Update Examination Record')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('examination.stage.index') }}">Examination Record</a></li>
    <li class="breadcrumb-item">Update</li>
</ul>
@endsection

@section('content')
<div class="container">
    <form action="{{ route('examination.record.update', [$examinationStage->key, $student->key]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex-space-between">
                        <h1 class="card-title">Update Examination Record</h1>
                        <div class="card-setting d-flex gap-2">
                            <a class="text-danger" href="{{ route('examination.record.index') }}"><span class="fa fa-arrow-left"></span></a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                        <div class="row" id="course-container">
                            @foreach(old('grades') as $key => $value)
                            <div class="col-md-6 col-sm-12 removable-{{ $key }}">
                                <div class="form-group">
                                    <label for="course-{{ $key }}">Course <span class="text-danger">*</span></label>
                                    <select class="form-control course-select" name="courses[{{ $key }}]" id="course-{{ $key }}" data-init-plugin="select2">
                                        <option value="" selected disabled>Select Course</option>
                                        @foreach(studentCourses($student, $examinationStage) as $course)
                                        <option value="{{ $course->course_id }}" @if(old('courses') && $course->course_id == old('courses')[$key]) selected @endif>{{ $course->course->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('courses.'.$key)
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    @error('courses')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-11 removable-{{ $key }}">
                                <div class="form-group">
                                    <label for="grade-{{ $key }}">Grade <span class="text-danger">*</span></label>
                                    <input id="grade-{{ $key }}" class="form-control" type="text" name="grades[{{ $key }}]" placeholder="Grade" value="{{ old('grades')[$key] }}">
                                    @error('grades.'.$key)
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @if($loop->first)
                            <div class="col-md-1 d-flex-center align-center mt-2">
                                <a href="javascript:;" class="text-primary add-course mb-3"><span class="fa fa-plus"></span></a>
                            </div>
                            @else
                            <div class="col-md-1 removable-{{ $key }} d-flex-center align-center mt-2">
                                <a href="javascript:;" class="text-danger remove-course mb-3" data-coursenum="{{ $key }}"><span class="fa fa-xmark"></span></a>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        @else
                        <div class="row" id="course-container">
                            @foreach($record->marks as $key => $value)
                            <div class="col-md-6 col-sm-12 removable-{{ $key + 1 }}">
                                <div class="form-group">
                                    <label for="course-{{ $key + 1 }}">Course <span class="text-danger">*</span></label>
                                    <select class="form-control course-select" name="courses[{{ $key + 1 }}]" id="course-{{ $key + 1 }}" data-init-plugin="select2">
                                        <option value="" selected disabled>Select Course</option>
                                        @foreach(studentCourses($student, $examinationStage) as $course)
                                        <option value="{{ $course->course_id }}" @if($course->course_id == $value->course_id) selected @endif>{{ $course->course->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-11 removable-{{ $key + 1 }}">
                                <div class="form-group">
                                    <label for="grade-{{ $key + 1 }}">Grade <span class="text-danger">*</span></label>
                                    <input id="grade-{{ $key + 1 }}" class="form-control" type="text" name="grades[{{ $key + 1 }}]" placeholder="Grade" value="{{ $value->grade }}">
                                </div>
                            </div>
                            @if($loop->first)
                            <div class="col-md-1 d-flex-center align-center mt-2">
                                <a href="javascript:;" class="text-primary add-course mb-3"><span class="fa fa-plus"></span></a>
                            </div>
                            @else
                            <div class="col-md-1 removable-{{ $key + 1 }} d-flex-center align-center mt-2">
                                <a href="javascript:;" class="text-danger remove-course mb-3" data-coursenum="{{ $key + 1 }}"><span class="fa fa-xmark"></span></a>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="gpa">GPA <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="gpa" placeholder="GPA" value="{{ old('gpa') ?? $record->gpa }}">
                                    @error('gpa')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-md btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('page-specific-style')
<style>
    .course-container.hide {
        display: none;
    }
</style>
@endsection

@section('page-specific-script')

<script>
    $(document).ready(function() {
        $('[data-init-plugin=select2]').select2();
        disableSelectedOptions();
    })

    var has_errors = "{{ $errors->any() }}";
    if (has_errors) {
        var grades = "{{ json_encode(old('grades')) }}";
        var decodedString = grades.replace(/&quot;/g, '"');
        var jsonObject = JSON.parse(decodedString);
        var keys = Object.keys(jsonObject);
        var lastKey = parseInt(keys[keys.length - 1]);
    }

    var maxField = "{{ count(studentCourses($student, $examinationStage)) }}";
    var courseCount = (lastKey && lastKey >= parseInt("{{ count($record->marks) }}") + 1) ? lastKey + 1 : parseInt("{{ count($record->marks) }}") + 1;

    $(document).on('click', '.add-course', function() {
        var courseLength = $('.course-select').length

        if (courseLength < maxField) {
            var html = `
                <div class="col-md-6 col-sm-12 removable-${courseCount}">
                    <div class="form-group">
                        <label for="course-${courseCount}">Course <span class="text-danger">*</span></label>
                        <select class="form-control course-select" name="courses[${courseCount}]" id="course-${courseCount}" data-init-plugin="select2">
                            <option value="" selected disabled>Select Course</option>
                            @foreach(studentCourses($student, $examinationStage) as $course)
                            <option value="{{ $course->course_id }}">{{ $course->course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-5 col-sm-11 removable-${courseCount}">
                    <div class="form-group">
                        <label for="grade-${courseCount}">Grade <span class="text-danger">*</span></label>
                        <input id="grade-${courseCount}" class="form-control" type="text" name="grades[${courseCount}]" placeholder="Grade">
                    </div>
                </div>
                <div class="col-md-1 removable-${courseCount} d-flex-center align-center mt-2">
                    <a href="javascript:;" class="text-danger remove-course mb-3" data-coursenum="${courseCount}"><span class="fa fa-xmark"></span></a>
                </div>
            `;

            $('#course-container').append(html);
            $('[data-init-plugin=select2]').select2();
            disableSelectedOptions();

            courseCount++;
        } else {
            toastr.warning("Max field added!");
        }
    });

    $(document).on('click', '.remove-course', function() {
        var courseNum = $(this).data('coursenum');
        $(`.removable-${courseNum}`).remove();
        disableSelectedOptions()
    })

    function disableSelectedOptions() {
        var selectedValues = [];
        $('.course-select').each(function() {
            var selectedValue = $(this).val();
            if (selectedValue !== null) {
                selectedValues.push(selectedValue);
            }
        });

        $('.course-select').each(function() {
            var $select = $(this);
            $select.find('option').prop('disabled', false);
            selectedValues.forEach(function(value) {
                $select.find(`option[value="${value}"]:not(:selected)`).prop('disabled', true);
            });
        });
    }

    $(document).on('change', '.course-select', function() {
        disableSelectedOptions();
    });
</script>

@endsection