@extends('layouts.app')

@section('title', 'Update Meeting')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('meeting.index') }}">Meeting</a></li>
    <li class="breadcrumb-item">Update</li>
</ul>
@endsection

@section('content')
<div class="container">
    <form action="{{ route('meeting.update', $meeting->key) }}" method="POST">
        @csrf
        @method("PUT")
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex-space-between">
                        <h1 class="card-title">Update Meeting</h1>
                        <div class="card-setting d-flex gap-2">
                            <a class="text-danger" href="{{ route('meeting.index') }}"><span class="fa fa-arrow-left"></span></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                        <div class="col-md-12">
                                <div class="form-group">
                                    <label for="topic">Topic <span class="text-danger">*</span></label>
                                    <input id="topic" class="form-control" type="text" name="topic" placeholder="Topic" value="{{ $meeting->topic }}">
                                    @error('topic')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start-time">Start Time <span class="text-danger">*</span></label>
                                    <input id="start-time" class="form-control" type="datetime-local" name="start_time" placeholder="Start Time" value="{{ $meeting->start_time }}">
                                    @error('start_time')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="duration">Duration <span class="text-danger">*</span></label>
                                    <input id="duration" class="form-control" type="text" name="duration" placeholder="Duration in minutes" value="{{ $meeting->duration }}">
                                    @error('duration')
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