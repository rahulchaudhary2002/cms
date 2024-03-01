@extends('layouts.app')

@section('title', 'Update Session')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('session.index') }}">Session</a></li>
    <li class="breadcrumb-item">Update</li>
</ul>
@endsection

@section('content')
<div class="container">
    <form action="{{ route('session.update', $session->key) }}" method="POST">
        @csrf
        @method("PUT")
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex-space-between">
                        <h1 class="card-title">Update Session</h1>
                        <div class="card-setting d-flex gap-2">
                            <a class="text-danger" href="{{ route('session.index') }}"><span class="fa fa-arrow-left"></span></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mt-2 mb-2">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input id="name" class="form-control" type="text" name="name" placeholder="Name" value="{{ $session->name }}" >
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="academic-year">Academic Year <span class="text-danger">*</span></label>
                                    <select class="form-control" name="academic_year" id="academic-year"  data-init-plugin="select2">
                                        <option value="{{ $session->academicYear->id }}">{{ $session->academicYear->name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="program">Program <span class="text-danger">*</span></label>
                                    <select class="form-control" name="program" id="program"  data-init-plugin="select2">
                                        <option value="{{ $session->semester->program->key }}">{{ $session->semester->program->name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="semester">Semester <span class="text-danger">*</span></label>
                                    <select class="form-control" name="semester" id="semester"  data-init-plugin="select2">
                                        <option value="{{ $session->semester->id }}">{{ $session->semester->name }}</option>
                                    </select>
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
    });
</script>

@endsection