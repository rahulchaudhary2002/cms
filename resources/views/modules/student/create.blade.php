@extends('layouts.app')

@section('title', 'Create Student')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('student.index') }}">Student</a></li>
    <li class="breadcrumb-item">Create</li>
</ul>
@endsection

@section('content')
<div class="container">
    <form class="row" action="{{ route('student.store') }}" method="POST">
        @csrf
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between">
                    <h1 class="card-title">Create Student</h1>
                    <div class="card-setting d-flex gap-2">
                        <a class="text-danger" href="{{ route('student.index') }}"><span class="fa fa-arrow-left"></span></a>
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
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input id="email" class="form-control" type="email" name="email" placeholder="Email" >
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="date_of_birth">Date of Birth <span class="text-danger">*</span></label>
                                <input id="date_of_birth" class="form-control" type="date" name="date_of_birth" >
                                @error('date_of_birth')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="role">Role <span class="text-danger">*</span></label>
                                <select class="form-control" name="role" id="role"  data-init-plugin="select2">
                                    <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                                </select>
                                @error('role')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
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
                                <input id="mobile" class="form-control" type="number" name="mobile" placeholder="Mobile" >
                                @error('mobile')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="permanent-address">Permanent Address <span class="text-danger">*</span></label>
                                <input id="permanent-address" class="form-control" type="text" name="permanent_address" placeholder="Permanent Address" >
                                @error('permanent_address')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="temporary-address">Temporary Address <span class="text-danger">*</span></label>
                                <input id="temporary-address" class="form-control" type="text" name="temporary_address" placeholder="Temporary Address" >
                                @error('temporary_address')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="nationality">Nationality</label>
                                <input id="nationality" class="form-control" type="text" name="nationality" placeholder="Nationality" >
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
            <div class="card">
                <div class="card-header d-flex-space-between">
                    <h4>Student Course Information</h4>
                </div>
                <div class="card-body">
                    <div class="row mt-2 mb-2">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="academic-year">Academic Year <span class="text-danger">*</span></label>
                                <select class="form-control" name="academic_year" id="academic-year"  data-init-plugin="select2">
                                    <option value="" selected disabled>Select Academic Year</option>
                                    @forelse($academicYears as $academicYear)
                                    <option value="{{ $academicYear->id }}">{{ $academicYear->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                @error('program')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="program">Program <span class="text-danger">*</span></label>
                                <select class="form-control" name="program" id="program"  data-init-plugin="select2">
                                    <option value="" selected disabled>Select Program</option>
                                    @forelse($programs as $program)
                                    <option value="{{ $program->id }}">{{ $program->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                @error('program')
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
                @include('includes.bulk-permission-checkbox', ['permissionsGroups' => $permissionsGroups, 'permissions' => $permissions, 'permissionsViaRole' => $permissionsViaRole])
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