@extends('layouts.app')

@section('title', 'Submit Assignment')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('assignment.index') }}">Assignment</a></li>
    <li class="breadcrumb-item">Submit</li>
</ul>
@endsection

@section('content')
<div class="container">
    <form action="{{ route('assignment.submission.store', $assignment->key) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex-space-between align-center">
                        <h1 class="card-title">Assignment of {{ auth()->user()->name }}</h1>
                        <div class="card-setting d-flex gap-1">
                            <a class="text-danger" title="Back" href="{{ route('assignment.index') }}"><span class="fa fa-arrow-left"></span></a>
                        </div>
                    </div>
                    <div class="card-body expand">
                        <div class="row">
                            <div class="col-md-12">
                                <strong>{{ $assignment->title }}</strong>
                                <div class="mt-2 mb-2">{!! $assignment->description !!}</div>
                                <span class="fa fa-calendar"></span> Submission Date: {{ $assignment->submission_date }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @foreach($assignment->questions as $key => $question)
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex-space-between align-center">
                        <h4>Question-{{ $key + 1 }}</h4>
                    </div>
                    <div class="card-body expand">
                        <div class="row">
                            <div class="col-md-12">
                                <strong>{{ $question->question }}</strong>
                                <div class="mt-2 mb-2">{!! $question->description !!}</div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        @if($question->answer_type == 'Writing')
                                        <div class="form-group">
                                            <strong>Answer</strong>
                                            <textarea id="answer-{{ $key }}" class="form-control" name="answers[{{ $question->id }}][write][]" placeholder="Answer" data-init-plugin="ckeditor"></textarea>
                                            @error('answers.'.$question->id.'.write.0')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        @else
                                        <div class="form-group">
                                            <strong>
                                                Upload Answer File - drag n' drop (Image/PDF) <span class="text-warning">- {{ ($question->multiple_upload == 1) ? 'You can upload upto 10 files' : 'You can upload only one file' }}</span>
                                            </strong>
                                            <div class="dropzone-assignment dropzone-assignment-{{ $key }} mt-2" style="min-height: 200px;" data-multiple-upload="{{ $question->multiple_upload }}" data-question-id="{{ $question->id }}">
                                                <div class="fallback">
                                                    <input name="file" type="file" accept="image/*,application/pdf">
                                                </div>
                                            </div>
                                            <div class="assignment-file"></div>
                                            <div class="remove-file"><input type="hidden" name="answers[{{ $question->id }}][file][]"></div>
                                            @error('answers.'.$question->id.'.file.0')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if($loop->last)
                            <div class="col-md-12">
                                <button class="btn btn-md btn-primary">Submit</button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </form>
</div>
@endsection

@section('page-specific-style')
<link href="{{ asset('assets/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/dropzone/css/custom.css') }}" rel="stylesheet" type="text/css" />

<style>
    .ck-editor__editable {
        min-height: 200px;
    }
</style>
@endsection

@section('page-specific-script')
<script src="{{ asset('assets/plugins/dropzone/dropzone.min.js') }}" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        var upload_url = "{{ route('assignment.upload.file') }}";
        var remove_url = "{{ route('assignment.remove.file') }}";

        $('[data-init-plugin=select2]').select2();

        Dropzone.autoDiscover = false;
        $('.dropzone-assignment').each((index, val) => {
            var multipleUpload = $(val).data('multipleUpload');
            var questionId = $(val).data('questionId');

            var myDropzone1 = new Dropzone(val, {
                url: upload_url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                thumbnailWidth: 240,
                thumbnailHeight: 240,
                addRemoveLinks: true,
                paramName: "file",
                acceptedFiles: ".pdf,image/*",
                uploadMultiple: false,
                maxFilesize: 5,
                maxFiles: (multipleUpload == 1) ? 10 : 1,
                init: function() {
                    this.on("processing", function(event) {});
                    this.on("success", function(file, response) {
                        if (response.status == 'success') {
                            $(val).siblings('.remove-file').html('');
                            $(val).siblings('.assignment-file').append('<input type="hidden" data-file="' + file.name + '" name="answers[' + questionId + '][file][]" value="' + response.filename + '"/>');
                        }
                    });
                    this.on("removedfile", function(file) {
                        if (!$(val).siblings('.assignment-file').children('[data-file="' + file.name + '"][value="maxfileexceed"]').length) {
                            $.ajax({
                                url: remove_url,
                                type: "post",
                                data: {
                                    file: $(val).siblings('.assignment-file').children('[data-file="' + file.name + '"]').val()
                                },
                                async: false,
                                success: function(response) {
                                    if (response.status == 'success') {
                                        $(val).siblings('.assignment-file').children('[value="' + $(val).siblings('.assignment-file').children('[data-file="' + file.name + '"]').val() + '"]').remove();
                                        if ($(val).siblings('.assignment-file').children().length == 0) {
                                            $(val).siblings('.remove-file').append('<input type="hidden" name="answers[' + questionId + '][file][]" />');
                                        }
                                    }
                                }
                            });
                        } else {
                            $(val).siblings('.assignment-file').children('[data-file="' + file.name + '"][value="maxfileexceed"]').remove();
                        }
                    });
                    this.on("maxfilesexceeded", function(file) {
                        $(val).siblings('.assignment-file').append('<input type="hidden" data-file="' + file.name + '" name="answers[' + questionId + '][file][]" value="maxfileexceed" />');
                        myDropzone1.removeFile(file);
                    });
                }
            })
        });
    });
</script>

@endsection