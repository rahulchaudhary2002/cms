@extends('layouts.app')

@section('title', 'Manage University')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item">University</li>
</ul>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between align-center">
                    <h1 class="card-title">Universities List</h1>
                    <div class="card-setting d-flex gap-2">
                        @if(auth()->user()->can('university.create'))
                        <a class="btn btn-sm btn-outline-warning text-center btn-rounded" href="{{ route('university.create') }}"><span class="fa fa-plus"></span> create university</a>
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
                            @forelse($result->universities as $key => $university)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $university->name }}</td>
                                <td>
                                    @if(auth()->user()->can('university.edit'))
                                    <a class="text-danger" href="{{ route('university.edit', $university->key) }}"><span class="fa fa-edit"></span></a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3">No university found at this moment.</td>
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