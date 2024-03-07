@extends('layouts.app')

@section('title', 'Update Assignment')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('assignment.index') }}">Assignment</a></li>
    <li class="breadcrumb-item">Update Assignment</li>
</ul>
@endsection

@section('content')
<div class="container">
    <form action="{{ route('assignment.update', $assignment->key) }}" method="POST">
        @csrf
        @method("PUT")
        <div class="row" id="question-container">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex-space-between align-center">
                        <h1 class="card-title">Update Assignment</h1>
                        <div class="card-setting d-flex gap-2">
                            <a class="text-danger" href="{{ route('assignment.index') }}"><span class="fa fa-arrow-left"></span></a>
                        </div>
                    </div>
                    <div class="card-body expand">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="{{ old('title') ?? $assignment->title }}">
                                    @error('title')
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
                                        <option value="{{ $academicYear->id }}" @if(old('academic_year') == $academicYear->id || $assignment->academic_year_id == $academicYear->id) selected @endif>{{ $academicYear->name }}</option>
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
                                        <option value="{{ $program->id }}" @if(old('program') == $program->id || $assignment->program_id == $program->id) selected @endif>{{ $program->name }}</option>
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
                                    <select class="form-control" name="semester" id="semester"  data-init-plugin="select2" data-semesterId="{{ old('semester') ?? $assignment->semester_id }}" data-sessions="{{ $sessions }}" data-courses="{{ $courses }}">
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
                                    <select class="form-control" name="session" id="session"  data-init-plugin="select2" data-sessionId="{{ old('session') ?? $assignment->session_id }}">
                                        <option value="" selected disabled>Select session</option>
                                    </select>
                                    @error('session')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="course">Course <span class="text-danger">*</span></label>
                                    <select class="form-control" name="course" id="course"  data-init-plugin="select2" data-courseId="{{ old('course') ?? $assignment->course_id }}">
                                        <option value="" selected disabled>Select course</option>
                                    </select>
                                    @error('course')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="submission_date">Submission Date <span class="text-danger">*</span></label>
                                    <input class="form-control" type="date" name="submission_date" id="submission_date" value="{{ old('submission_date') ?? $assignment->submission_date ?? now()->format('Y-m-d') }}" min="{{ now()->format('Y-m-d') }}" >
                                    @error('submission_date')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <input type="checkbox" id="allow-late-submission" name="allow_late_submission" value="1" @if(old('allow_late_submission') == 1 || $assignment->late_submission == 1) checked @endif>
                                    <label for="allow-late-submission">Allow Late Submission</label>
                                    @error('allow_late_submission')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" id="description" data-init-plugin="ckeditor"  placeholder="Assignment Description">{!! old('description') ?? $assignment->description !!}</textarea>
                                    @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($errors->any())
            @foreach(old('question_titles') as $key => $value)
            <div class="col-md-12 question-container">
                <div class="card">
                    <div class="card-header d-flex-space-between align-center">
                        <h4>Question-{{ $loop->index + 1 }}</h4>
                        <div class="card-setting d-flex gap-1">
                            <a class="text-primary add-question" title="Add Question" href="javascript:;"><span class="fa fa-plus"></span></a>
                            @if(!$loop->first)
                            <a class="text-danger remove-question" title="Remove Question" href="javascript:;"><span class="fa fa-minus"></span></a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body expand">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="question-title-{{ $loop->index + 1 }}">Question Title <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="question_titles[{{ $loop->index + 1 }}]" id="question-title-{{ $loop->index + 1 }}" placeholder="Question title"  value="{{ old('question_titles')[$key] }}">
                                    @error('question_titles.'.$key)
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="answer-type-{{ $loop->index + 1 }}">Answer Type <span class="text-danger">*</span></label>
                                    <select class="form-control answer-type" id="answer-type-{{ $loop->index + 1 }}"  data-init-plugin="select2">
                                        <option value="" selected disabled>Select answer type</option>
                                        <option value="Writing" @if(old('answer_types')[$key] == 'write') selected @endif>Submit By Writing</option>
                                        <option value="File Upload" @if(old('answer_types')[$key] == 'file') selected @endif>Submit By File Upload</option>
                                    </select>
                                    <input type="hidden" name="answer_types[{{ $loop->index + 1 }}]" value="{{ old('answer_types')[$key] }}">
                                    @error('answer_types.'.$key)
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 multiple-upload @if(old('answer_types')[$key] != 'file') hidden @endif">
                                <div class="checkbox mt-6">
                                    <input type="checkbox" id="multiple-upload-{{ $loop->index + 1 }}" class="multiple-upload-checkbox" @if(old('multiple_file_uploads')[$key] == 1) checked @endif>
                                    <label for="multiple-upload-{{ $loop->index + 1 }}">Allow Multiple File Uploads</label>
                                </div>
                                <input class="multiple-file-upload" type="hidden" name="multiple_file_uploads[{{ $loop->index + 1 }}]" value="{{ old('multiple_file_uploads')[$key] == 1 ? old('multiple_file_uploads')[$key] : 0 }}">
                                @error('multiple_file_uploads.'.$key)
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="question-description-{{ $loop->index + 1 }}">Description</label>
                                    <textarea id="question-description-{{ $loop->index + 1 }}" class="form-control" name="question_descriptions[{{ $loop->index + 1 }}]" placeholder="Question Description" data-init-plugin="ckeditor">{!! old('question_descriptions')[$key] !!}</textarea>
                                    @error('question_descriptions.'.$key)
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @if($loop->last)
                            <div class="col-md-12 submit-button">
                                <button class="btn btn-md btn-primary">Submit</button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            @foreach($assignment->questions as $key => $question)
            <div class="col-md-12 question-container">
                <div class="card">
                    <div class="card-header d-flex-space-between align-center">
                        <h4>Question-{{ $key + 1 }}</h4>
                        <div class="card-setting d-flex gap-1">
                            <a class="text-primary add-question" title="Add Question" href="javascript:;"><span class="fa fa-plus"></span></a>
                            @if(!$loop->first)
                            <a class="text-danger remove-question" title="Remove Question" href="javascript:;"><span class="fa fa-minus"></span></a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body expand">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="question-title-{{ $key + 1 }}">Question Title <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="question_titles[{{ $key + 1 }}]" id="question-title-{{ $key + 1 }}" placeholder="Question title"  value="{{ $question->question }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="answer-type-{{ $key + 1 }}">Answer Type <span class="text-danger">*</span></label>
                                    <select class="form-control answer-type" id="answer-type-{{ $key + 1 }}"  data-init-plugin="select2">
                                        <option value="" selected disabled>Select answer type</option>
                                        <option value="Writing" @if($question->answer_type == 'Writing') selected @endif>Submit By Writing</option>
                                        <option value="File Upload" @if($question->answer_type == 'File Upload') selected @endif>Submit By File Upload</option>
                                    </select>
                                    <input type="hidden" name="answer_types[{{ $key + 1 }}]" value="{{ $question->answer_type }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 multiple-upload @if($question->answer_type != 'File Upload') hidden @endif">
                                <div class="checkbox mt-6">
                                    <input type="checkbox" id="multiple-upload-{{ $key + 1 }}" class="multiple-upload-checkbox" @if($question->multiple_upload == 1) checked @endif>
                                    <label for="multiple-upload-{{ $key + 1 }}">Allow Multiple File Uploads</label>
                                </div>
                                <input class="multiple-file-upload" type="hidden" name="multiple_file_uploads[{{ $key + 1 }}]" value="{{ $question->multiple_upload == 1 ? $question->multiple_upload : 0 }}">
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="question-description-{{ $key + 1 }}">Description</label>
                                    <textarea id="question-description-{{ $key + 1 }}" class="form-control" name="question_descriptions[{{ $key + 1 }}]" placeholder="Question Description" data-init-plugin="ckeditor">{!! $question->description !!}</textarea>
                                </div>
                            </div>
                            @if($loop->last)
                            <div class="col-md-12 submit-button">
                                <button class="btn btn-md btn-primary">Submit</button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </form>
</div>
@endsection

@section('page-specific-style')
<style>
    .question-container.hide {
        display: none;
    }

    .question-container,
    .submit-button {
        transition: 0.5s;
    }

    .ck-editor__editable {
        min-height: 200px;
    }
</style>
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

    var has_errors = "{{ $errors->any() }}";
    if (has_errors) {
        var questionTitles = "{{ json_encode(old('question_titles')) }}";
        var decodedString = questionTitles.replace(/&quot;/g, '"');
        var jsonObject = JSON.parse(decodedString);
        var keys = Object.keys(jsonObject);
        var lastKey = parseInt(keys[keys.length - 1]);
    }

    var question_num = (lastKey && lastKey >= parseInt("{{ count($assignment->questions) }}") + 1) ? lastKey + 1 : parseInt("{{ count($assignment->questions) }}") + 1;

    $(document).on("click", '.add-question', function(e) {
        e.preventDefault();
        var html = `
            <div class="col-md-12 question-container hide">
                <div class="card">
                    <div class="card-header d-flex-space-between align-center">
                        <h4>Question-${question_num}</h4>
                        <div class="card-setting d-flex gap-1">
                            <a class="text-primary add-question" title="Add Question" href="javascript:;"><span class="fa fa-plus"></span></a>
                            <a class="text-danger card-collapsed remove-question" title="Remove Question" href="javascript:;"><span class="fa fa-xmark"></span></a>
                        </div>
                    </div>
                    <div class="card-body expand">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="question-title-${question_num}">Question Title <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="question_titles[${question_num}]" id="question-title-${question_num}" placeholder="Question title" >
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="answer-type-${question_num}">Answer Type <span class="text-danger">*</span></label>
                                    <select class="form-control answer-type" id="answer-type-${question_num}"  data-init-plugin="select2">
                                        <option value="" selected disabled>Select answer type</option>
                                        <option value="Writing">Submit By Writing</option>
                                        <option value="File Upload">Submit By File Upload</option>
                                    </select>
                                    <input type="hidden" name="answer_types[${question_num}]">
                                    @error('answer_type')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 multiple-upload hidden">
                                <div class="checkbox mt-6">
                                    <input type="checkbox" id="multiple-upload-${question_num}" class="multiple-upload-checkbox">
                                    <label for="multiple-upload-${question_num}">Allow Multiple File Uploads</label>
                                </div>
                                <input class="multiple-file-upload" type="hidden" name="multiple_file_uploads[${question_num}]" value="0">
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="question-description-${question_num}">Description</label>
                                    <textarea id="question-description-${question_num}" class="form-control" name="question_descriptions[${question_num}]" placeholder="Question Description" data-init-plugin="ckeditor"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 submit-button">
                                <button class="btn btn-md btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $('.submit-button').remove();
        $('#question-container').append(html);
        $('.question-container').slideDown(500);
        $('[data-init-plugin=select2]').select2();

        $('.question-container.hide:last [data-init-plugin=ckeditor]').each(function() {
            ClassicEditor.create(this, {
                    ckfinder: {
                        uploadUrl: "{{ route('ck-file-upload').'?_token='.csrf_token() }}"
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        });

        updateQuestionNumbers();
        question_num++;
    });

    $(document).on("click", '.remove-question', function(e) {
        $('.submit-button').remove();
        var questionContainer = $(this).closest('.question-container');

        var html = `
            <div class="col-md-12 submit-button">
                <button class="btn btn-md btn-primary">Submit</button>
            </div>
        `;

        questionContainer.slideUp(500, function() {
            questionContainer.remove();
            updateQuestionNumbers();
            $('#question-container').find('.question-container').last().children().children('.card-body').children('.row').append(html);
        });
    });

    $(document).on("change", ".answer-type", function(e) {
        e.preventDefault();
        var value = $(this).val();
        $(this).siblings('input').val(value);

        if (value == 'File Upload') {
            $(this).parents('.card-body').children().children('.multiple-upload').removeClass('hidden');
        } else {
            $(this).parents('.card-body').children().children('.multiple-upload').removeClass('hidden').addClass('hidden');
        }
    });

    $(document).on("click", ".multiple-upload-checkbox", function() {
        if ($(this).prop('checked') == true) {
            $(this).parents('.multiple-upload').children('.multiple-file-upload').val(1);
        } else {
            $(this).parents('.multiple-upload').children('.multiple-file-upload').val(0);
        }
    });

    function updateQuestionNumbers() {
        $('.question-container').each(function(index) {
            $(this).find('.card-header h4').text('Question-' + (index + 1));
        });
    }

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

    function updateCourseOptions() {
        let courses = $('#semester').data('courses');
        let semesterId = $('#semester').val();
        let courseId = $('#course').data('courseid');

        var filteredCourses = courses.filter(function(course) {
            return course.semester.id == semesterId;
        });

        var content = '<option value="" selected disabled>Select course</option>';

        var optionStrings = filteredCourses.map(element => {
            return `<option value="${element.id}" ${element.id == courseId ? 'selected' : ''}>${element.name}</option>`;
        });

        content += optionStrings.join('');
        $('#course').html(content);
    }
</script>

@endsection