@extends('layouts.app')

@section('title', 'Manage Permission')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item">Permission</li>
</ul>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between align-center">
                    <h1 class="card-title">Permissions List</h1>
                    <div class="card-setting d-flex gap-2">
                        @if(auth()->user()->can('permission.create'))
                        <a class="btn btn-sm btn-outline-warning text-center btn-rounded" href="{{ route('permission.create') }}"><span class="fa fa-plus"></span> create permission</a>
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
                                    <input type="text" name="type" id="type" class="form-control" placeholder="Type (Group)" value="{{ request()->get('type') }}">
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
                                <th>Type (Group)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($result->permissions as $key => $permission)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->type }}</td>
                                <td>
                                    @if(auth()->user()->can('permission.edit') && $permission->primary == 0)
                                    <a class="text-danger" href="{{ route('permission.edit', $permission->key) }}"><span class="fa fa-edit"></span></a>
                                    @else
                                    <span class="text-danger">Unauthorized</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">No permission found at this moment.</td>
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