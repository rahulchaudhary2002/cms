@extends('layouts.app')

@section('title', 'Manage Academic Year')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item">Academic Year</li>
</ul>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between align-center">
                    <h1 class="card-title">Academic Years List</h1>
                    <div class="card-setting d-flex gap-2">
                        @if(auth()->user()->can('academic-year.create'))
                        <a class="btn btn-sm btn-outline-warning text-center btn-rounded" href="{{ route('academic-year.create') }}"><span class="fa fa-plus"></span> create academicYear</a>
                        @endif
                    </div>
                </div>
                <div class="card-body expand">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($result->academicYears as $key => $academicYear)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $academicYear->name }}</td>
                                <td>
                                    @if(auth()->user()->can('academic-year.edit'))
                                    <a class="text-danger" href="{{ route('academic-year.edit', $academicYear->key) }}"><span class="fa fa-edit"></span></a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3">No academic year found at this moment.</td>
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