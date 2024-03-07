@extends('layouts.app')

@section('title', 'Update Permission')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('permission.index') }}">Permission</a></li>
    <li class="breadcrumb-item">Update</li>
</ul>
@endsection

@section('content')
<div class="container">
    <form class="row" action="{{ route('permission.update', $permission->key) }}" method="POST">
        @csrf
        @method("PUT")
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between">
                    <h1 class="card-title">Update Permission</h1>
                    <div class="card-setting d-flex gap-2">
                        <a class="text-danger" href="{{ route('permission.index') }}"><span class="fa fa-arrow-left"></span></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mt-2 mb-2">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input id="name" class="form-control" type="text" name="name" placeholder="Name" value="{{ $permission->name }}" >
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="type">Type <span class="text-danger">*</span> (Note:Do not use white spaces)</label>
                                <input id="type" class="form-control" type="text" name="type" placeholder="Type" value="{{ $permission->type }}" pattern="^\S+$" >
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
                                    <option value="{{ $url->id }}" @if($permission->url->id == $url->id) selected @endif>{{ $url->name }}</option>
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
                            <input class="form-check-input check-role" type="checkbox" name="roles[]" value="{{ $value->id }}" id="role{{ $key }}" @if(old('roles.'.$key)==$value->id) checked @endif @if($value->hasPermissionTo($permission->key)) checked @endif>
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

        function checkParentRoleCheckbox() {
            totalrolecheckbox = $('input.check-role:checkbox:not(":checked")').length;
            if (totalrolecheckbox == 0) {
                $('#check-role').prop('checked', true);
            }
        }

        checkParentRoleCheckbox();

        $('body').on('click', 'button[type=reset]', function(e) {
            e.preventDefault();
            var form = $(this).closest('form')[0];
            form.reset();
            checkParentRoleCheckbox();
        })

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