@extends('layouts.app')

@section('title', 'Create Examination Record')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('examination.stage.index') }}">Examination Record</a></li>
    <li class="breadcrumb-item">Create</li>
</ul>
@endsection

@section('content')
<div class="container">
    <form action="{{ route('examination.record.store', [$examinationStage->key, $student->key]) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex-space-between">
                        <h1 class="card-title">Create Examination Record</h1>
                        <div class="card-setting d-flex gap-2">
                            <a class="text-danger" href="{{ route('examination.record.index') }}"><span class="fa fa-arrow-left"></span></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row" id="course-container">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="course">Course <span class="text-danger">*</span></label>
                                    <select class="form-control course-select" name="courses[0]" id="course" data-init-plugin="select2">
                                        <option value="" selected disabled>Select Course</option>
                                        @foreach(studentCourses($student, $examinationStage) as $course)
                                        <option value="{{ $course->course_id }}">{{ $course->course->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('course')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-11">
                                <div class="form-group">
                                    <label for="grade">Grade <span class="text-danger">*</span></label>
                                    <input id="grade" class="form-control" type="text" name="grades[0]" placeholder="Grade">
                                    @error('grade')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-1 d-flex-center align-center mt-2">
                                <a href="javascript:;" class="text-primary add-course mb-3"><span class="fa fa-plus"></span></a>
                            </div>
                        </div>
                        <div class="row">
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
    })

    var maxField = "{{ count(studentCourses($student, $examinationStage)) }}"
    var courseCount = 1;

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