@extends('layouts.app')

@section('title', 'Manage Staff')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item">Staff</li>
</ul>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between align-center">
                    <h1 class="card-title">Staffs List</h1>
                    <div class="card-setting d-flex gap-2">
                        <!-- <a class="text-warning card-body-collapsed" href="#"><span class="fa fa-angle-down"></span></a>
                        <a class="text-success card-refresh" href="#"><span class="fa fa-rotate"></span></a>
                        <a class="text-danger card-collapsed" href="#"><span class="fa fa-xmark"></span></a> -->
                        @if(auth()->user()->can('user.create'))
                        <a class="btn btn-sm btn-outline-warning text-center btn-rounded" href="{{ route('user.create') }}"><span class="fa fa-plus"></span> create staff</a>
                        @endif
                    </div>
                </div>
                <div class="card-body expand">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ request()->get('name') }}">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <select class="form-control" name="role" id="role"  data-init-plugin="select2">
                                        <option value="">Select role</option>
                                        @forelse($roles as $role)
                                        <option value="{{ $role->key }}" @if(request()->get('role') == $role->key) selected @endif>{{ $role->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group btn-mt-1">
                                    <button class="btn btn-md btn-primary"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($result->users as $key => $user)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->mobile }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->roles[0]->role->name }}</td>
                                <td>
                                    <a class="text-success mr-1" href="{{ route('user.show', $user->key) }}"><span class="fa fa-eye"></span></a>
                                    @if(auth()->user()->can('user.edit') && $user->is_super == 0)
                                    <a class="text-danger mr-1" href="{{ route('user.edit', $user->key) }}"><span class="fa fa-edit"></span></a>
                                    @endif
                                    @if($user->hasRole('teacher'))
                                    <a class="text-primary" title="Assign Course" href="{{ route('course.assign.create', $user->key) }}"><span class="fa fa-user-plus"></span></a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">No staff found at this moment.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @include('includes.pagination', ['current' => $result->currentPage ?? 1, 'total' => $result->totalRecords > 0 ? $result->totalRecords : 1, 'length' => $result->recordsPerPage ?? 10, 'size' => $result->paginationSize ?? 2])
                </div>
            </div>
        </div>
    </div>
</div>

@endsection