@extends('layouts.app')

@section('title', 'Create Semester')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('semester.index') }}">Semester</a></li>
    <li class="breadcrumb-item">Create</li>
</ul>
@endsection

@section('content')
<div class="container">
    <form action="{{ route('semester.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex-space-between">
                        <h1 class="card-title">Create Semester</h1>
                        <div class="card-setting d-flex gap-2">
                            <a class="text-danger" href="{{ route('semester.index') }}"><span class="fa fa-arrow-left"></span></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input id="name" class="form-control" type="text" name="name" placeholder="Name" value="{{ old('name') }}">
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="order">Order <span class="text-danger">*</span></label>
                                    <input id="order" class="form-control" type="number" name="order" placeholder="Order" value="{{ old('order') }}">
                                    @error('order')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="number_of_elective_courses">Number of Elective Courses</label>
                                    <input id="number_of_elective_courses" class="form-control" type="number" name="number_of_elective_courses" placeholder="Number of Elective Courses" value="{{ old('number_of_elective_courses') }}">
                                    @error('number_of_elective_courses')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="program">Program <span class="text-danger">*</span></label>
                                    <select class="form-control" name="program" id="program"  data-init-plugin="select2">
                                        <option value="" selected disabled>Select program</option>
                                        @foreach($programs as $program)
                                        <option value="{{ $program->id }}" @if($program->id == old('program')) selected @endif>{{ $program->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('program')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
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
    })
</script>

@endsection