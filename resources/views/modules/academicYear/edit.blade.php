@extends('layouts.app')

@section('title', 'Update Academic Year')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('academic-year.index') }}">Academic Year</a></li>
    <li class="breadcrumb-item">Update</li>
</ul>
@endsection

@section('content')
<div class="container">
    <form action="{{ route('academic-year.update', $academicYear->key) }}" method="POST">
        @csrf
        @method("PUT")
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex-space-between">
                        <h1 class="card-title">Update Academic Year</h1>
                        <div class="card-setting d-flex gap-2">
                            <a class="text-danger" href="{{ route('academic-year.index') }}"><span class="fa fa-arrow-left"></span></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mt-2 mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input id="name" class="form-control" type="text" name="name" placeholder="Name" value="{{ $academicYear->name }}" >
                                    @error('name')
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