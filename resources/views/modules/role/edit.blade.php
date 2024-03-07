@extends('layouts.app')

@section('title', 'Update Role')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Role</a></li>
    <li class="breadcrumb-item">Edit</li>
</ul>
@endsection

@section('content')
<div class="container">
    <form class="row" action="{{ route('role.update', $role->key) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between">
                    <h1 class="card-title">Update Role</h1>
                    <div class="card-setting d-flex gap-2">
                        <a class="text-danger" href="{{ route('role.index') }}"><span class="fa fa-arrow-left"></span></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mt-2 mb-2">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input id="name" class="form-control" type="text" name="name" placeholder="Name"  value="{{ $role->name }}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row permission-container">
                @php
                $supersubset = $permissions->pluck('id')->toArray();
                $rolePermissionsIds = $role->permissions()->pluck('permission_id')->toArray();
                @endphp
                <div class="col-md-12">
                    <div class="d-flex-space-between">
                        <label class="mt-2">Permissions</label>
                        <div class="checkbox mt-2">
                            <input type="checkbox" id="check-permission" @if(!array_diff($supersubset, $rolePermissionsIds)) checked @endif>
                            <label for="check-permission">Select all permissions</label>
                            @error('permissions')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                @foreach($permissionsGroups as $type => $data)
                @php $subset = $data->pluck('id')->toArray(); @endphp
                <div class="col-md-3 col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex-space-between">
                            <div class="checkbox">
                                <input type="checkbox" class="check-permission" onchange="childrenPermissionCheckbox('{{ $type }}', this)" id="check-permission-{{ $type }}" @if(!array_diff($subset, $role->getPermissionIdsByType($type))) checked @endif>
                                <label for="check-permission-{{ $type }}">Select all {{ $type }}</label>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach($data as $key => $value)
                            <div class="checkbox mt-2 mb-2">
                                <input class="check-permission check-permission-{{ $type }}" onchange="parentPermissionCheckbox('{{ $type }}', this)" type="checkbox" name="permissions[]" value="{{ $value->id }}" id="permission-{{ $type }}-{{ $key }}" @if($role->hasPermissionTo($value->key)) checked @endif>
                                <label for="permission-{{ $type }}-{{ $key }}">{{ $value->name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
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
        $('[data-init-plugin=select2]').select2();
        var current_url = '{{ url()->current() }}';

        $('body').on('change', '#role', function() {
            var id = $(this).val();
            $.ajax({
                type: 'get',
                url: current_url,
                data: {
                    id: id
                },
                success: function(res) {
                    $(".permission-container").html(res);
                }
            });
        })

        $('body').on('change', '#check-permission', function() {
            totalpermissioncheckbox = $('input.check-permission:checkbox:not(":checked")').length;

            if ($(this).is(':checked')) {
                $('.check-permission').prop('checked', true);
            } else {
                $('.check-permission').prop('checked', false);
            }
            totalpermissioncheckbox = $('input.check-permission:checkbox:not(":checked")').length;
        })

        $('body').on('change', '.check-permission', function() {
            totalpermissioncheckbox = $('input.check-permission:checkbox:not(":checked")').length;

            if ($(this).is(':checked')) {
                if (totalpermissioncheckbox == 0) {
                    $('#check-permission').prop('checked', true);
                }
            } else {
                $('#check-permission').prop('checked', false);
            }
            totalpermissioncheckbox = $('input.check-permission:checkbox:not(":checked")').length;
        })
    })

    function childrenPermissionCheckbox(type, $this) {
        if ($($this).is(':checked')) {
            $('.check-permission-' + type).prop('checked', true);
        } else {
            $('.check-permission-' + type).prop('checked', false);
        }
    }

    function parentPermissionCheckbox(type, $this) {
        totalpermissioncheckbox = $('input.check-permission-' + type + ':checkbox:not(":checked")').length;

        if ($($this).is(':checked')) {
            if (totalpermissioncheckbox == 0) {
                $('#check-permission-' + type).prop('checked', true);
            }
        } else {
            $('#check-permission-' + type).prop('checked', false);
        }
        totalpermissioncheckbox = $('input.check-permission-' + type + ':checkbox:not(":checked")').length;
    }
</script>

@endsection