@extends('layouts.app')

@section('title', 'Create Role')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Role</a></li>
    <li class="breadcrumb-item">Create</li>
</ul>
@endsection

@section('content')
<div class="container">
    <form class="row" action="{{ route('role.store') }}" method="POST">
        @csrf
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between">
                    <h1 class="card-title">Create Role</h1>
                    <div class="card-setting d-flex gap-2">
                        <a class="text-danger" href="{{ route('role.index') }}"><span class="fa fa-arrow-left"></span></a>
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
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row permission-container">
                @include('includes.bulk-permission-checkbox', $permissionsGroups)
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