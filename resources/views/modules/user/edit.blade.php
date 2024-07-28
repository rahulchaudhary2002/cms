@extends('layouts.app')

@section('title', 'Update Staff')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Staff</a></li>
    <li class="breadcrumb-item">Edit</li>
</ul>
@endsection

@section('content')
<div class="container">
    <form class="row" action="{{ route('user.update', $user->key) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between">
                    <h1 class="card-title">Update Staff</h1>
                    <div class="card-setting d-flex gap-2">
                        <a class="text-danger" href="{{ route('user.index') }}"><span class="fa fa-arrow-left"></span></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mt-2 mb-2">
                        <div class="col-md-3 col-sm-12">
                            <div class="row">
                                <div class="col-md-12" style="margin: auto;">
                                    <img src="{{ $user->image ? asset('storage/users/'.$user->image) : asset('assets/images/noimage.jpg') }}" alt="User Image" style="border-radius: 20px; width:85px; height:85px" id="selected-user-img">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="file" name="file" id="file" accept="image/*" hidden onchange="handleFileUpload(event)">
                                <button class="btn btn-md btn-primary form-control" type="button" onclick="$('#file').click()"><span class="fa fa-image"></span> select image</button>
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-12">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input id="name" class="form-control" type="text" name="name" placeholder="Name" value="{{ $user->name }}">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input id="email" class="form-control" type="email" name="email" placeholder="Email" value="{{ $user->email }}" readonly>
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="date_of_birth">Date of Birth <span class="text-danger">*</span></label>
                                        <input id="date_of_birth" class="form-control" type="date" name="date_of_birth" value="{{ $user->dob }}">
                                        @error('date_of_birth')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="role">Role <span class="text-danger">*</span></label>
                                        <select class="form-control" name="roles[]" id="role" data-init-plugin="select2" multiple>
                                            @foreach($roles as $role)
                                            <option value="{{ $role->id }}" @if($user->hasRole($role->key)) selected @endif>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('roles')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between">
                    <h4>Contact Information</h4>
                </div>
                <div class="card-body">
                    <div class="row mt-2 mb-2">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="mobile">Mobile <span class="text-danger">*</span></label>
                                <input id="mobile" class="form-control" type="number" name="mobile" placeholder="Mobile" value="{{ $user->mobile }}">
                                @error('mobile')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="permanent-address">Permanent Address <span class="text-danger">*</span></label>
                                <input id="permanent-address" class="form-control" type="text" name="permanent_address" placeholder="Permanent Address" value="{{ $user->permanent_address }}">
                                @error('permanent_address')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="temporary-address">Temporary Address <span class="text-danger">*</span></label>
                                <input id="temporary-address" class="form-control" type="text" name="temporary_address" placeholder="Temporary Address" value="{{ $user->temporary_address }}">
                                @error('temporary_address')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="nationality">Nationality</label>
                                <input id="nationality" class="form-control" type="text" name="nationality" placeholder="Nationality" value="{{ $user->nationality }}">
                                @error('nationality')
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
                $userPermissionsIds = $user->permissions()->pluck('permission_id')->toArray();
                @endphp
                <div class="col-md-12">
                    <div class="d-flex-space-between">
                        <label class="mt-2">Permissions</label>
                        <div class="checkbox mt-2">
                            <input type="checkbox" id="check-permission" @if(!array_diff($supersubset, $userPermissionsIds)) checked @endif>
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
                                <input type="checkbox" class="check-permission" onchange="childrenPermissionCheckbox('{{ $type }}', this)" id="check-permission-{{ $type }}" @if(!array_diff($subset, $user->getPermissionIdsByType($type))) checked @endif>
                                <label for="check-permission-{{ $type }}">Select all {{ $type }}</label>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach($data as $key => $value)
                            <div class="checkbox mt-2 mb-2">
                                <input class="check-permission check-permission-{{ $type }}" onchange="parentPermissionCheckbox('{{ $type }}', this)" type="checkbox" name="permissions[]" value="{{ $value->id }}" id="permission-{{ $type }}-{{ $key }}" @if($user->hasPermissionTo($value->key)) checked @endif>
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
            var ids = $(this).val();
            $.ajax({
                type: 'get',
                url: current_url,
                data: {
                    ids: ids
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

    function handleFileUpload(event) {
        const fileInput = event.target;
        const previewImage = $('#selected-user-img');

        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.attr('src', e.target.result);
                previewImage.show();
            };

            reader.readAsDataURL(fileInput.files[0]);
        }
    }
</script>

@endsection