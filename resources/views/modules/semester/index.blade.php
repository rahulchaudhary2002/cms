@extends('layouts.app')

@section('title', 'Manage Semester')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item">Semester</li>
</ul>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between align-center">
                    <h1 class="card-title">Semesters List</h1>
                    <div class="card-setting d-flex gap-2">
                        @if(auth()->user()->can('semester.create'))
                        <a class="btn btn-sm btn-outline-warning text-center btn-rounded" href="{{ route('semester.create') }}"><span class="fa fa-plus"></span> create program</a>
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
                                    <select id="program" class="form-control" name="program" data-init-plugin="select2">
                                        <option value="">Select Program</option>
                                        @foreach($programs as $program)
                                        <option value="{{ $program->key }}" @if(request()->get('program') == $program->key) selected @endif>{{ $program->name }}</option>
                                        @endforeach
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
                                <th>Order</th>
                                <th>Number of elective courses</th>
                                <th>Program</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($result->semesters as $key => $semester)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $semester->name }}</td>
                                <td>{{ $semester->order }}</td>
                                <td>{{ $semester->number_of_elective_courses ?? 0 }}</td>
                                <td>{{ $semester->program->name ?? '' }}</td>
                                <td>
                                    @if(auth()->user()->can('semester.edit'))
                                    <a class="text-danger" href="{{ route('semester.edit', $semester->key) }}"><span class="fa fa-edit"></span></a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">No semester found at this moment.</td>
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