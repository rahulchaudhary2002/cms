@extends('layouts.app')

@section('title', 'Create Permission')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('permission.index') }}">Permission</a></li>
    <li class="breadcrumb-item">Create</li>
</ul>
@endsection

@section('content')
<div class="container">
    <form class="row" action="{{ route('permission.store') }}" method="POST">
        @csrf
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between">
                    <h1 class="card-title">Create Permission</h1>
                    <div class="card-setting d-flex gap-2">
                        <a class="text-danger" href="{{ route('permission.index') }}"><span class="fa fa-arrow-left"></span></a>
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
                                <label for="type">Type <span class="text-danger">*</span> (Note:Do not use white spaces)</label>
                                <input id="type" class="form-control" type="text" name="type" placeholder="Type" pattern="^\S+$" >
                                @error('type')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="url">Url <span class="text-danger">*</span></label>
                                <select class="form-control" name="url" id="url"  data-init-plugin="select2">
                                    <option value="" selected disabled>Select url</option>
                                    @foreach($urls as $url)
                                    <option value="{{ $url->id }}">{{ $url->name }}</option>
                                    @endforeach
                                </select>
                                @error('url')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header d-flex-space-between">
                    <label for="roles">Roles</label>
                    <div class="checkbox">
                        <input type="checkbox" id="check-role">
                        <label for="check-role">Select all roles</label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="checkbox-container">
                        @foreach($roles as $key => $value)
                        @if($value->key == 'superadmin')
                        @continue
                        @endif
                        <div class="checkbox mt-2 mb-2">
                            <input class="form-check-input check-role" type="checkbox" name="roles[]" value="{{ $value->id }}" id="role{{ $key }}" @if(old('roles.'.$key)==$value->id) checked @endif>
                            <label class="form-check-label" for="role{{ $key }}">{{ $value->name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <button type="submit" class="btn btn-md btn-primary">Submit</button>
            <button type="reset" class="btn btn-md btn-warning">Reset</button>
        </div>
    </form>
</div>

@endsection




@section('page-specific-script')

<script>
    $(document).ready(function() {
        var totalrolecheckbox = $('input.check-role:checkbox:not(":checked")').length;

        $('body').on('change', '#check-role', function() {
            totalrolecheckbox = $('input.check-role:checkbox:not(":checked")').length;

            if ($(this).is(':checked')) {
                $('.check-role').prop('checked', true);
            } else {
                $('.check-role').prop('checked', false);
            }
            totalrolecheckbox = $('input.check-role:checkbox:not(":checked")').length;
        })

        $('body').on('change', '.check-role', function() {
            totalrolecheckbox = $('input.check-role:checkbox:not(":checked")').length;

            if ($(this).is(':checked')) {
                if (totalrolecheckbox == 0) {
                    $('#check-role').prop('checked', true);
                }
            } else {
                $('#check-role').prop('checked', false);
            }
            totalrolecheckbox = $('input.check-role:checkbox:not(":checked")').length;
        })
    })
</script>

@endsection