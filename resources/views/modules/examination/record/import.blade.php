@extends('layouts.app')

@section('title', 'Import Excel')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('examination.stage.index') }}">Examination Record</a></li>
    <li class="breadcrumb-item">Import Excel</li>
</ul>
@endsection

@section('content')
<div class="container">
    <form action="{{ route('examination.record.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex-space-between">
                        <h1 class="card-title">Import Excel</h1>
                        <div class="card-setting d-flex gap-2">
                            <a class="text-danger" href="{{ route('examination.record.index') }}"><span class="fa fa-arrow-left"></span></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="file">File <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="file">
                                    @error('file')
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

</style>
@endsection

@section('page-specific-script')

@endsection