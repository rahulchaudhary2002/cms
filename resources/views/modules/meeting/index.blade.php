@extends('layouts.app')

@section('title', 'Manage Meeting')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item">Meeting</li>
</ul>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between align-center">
                    <h1 class="card-title">Meetings List</h1>
                    <div class="card-setting d-flex gap-2">
                        @if(auth()->user()->can('meeting.create'))
                        <a class="btn btn-sm btn-outline-warning text-center btn-rounded" href="{{ route('meeting.create') }}"><span class="fa fa-plus"></span> create meeting</a>
                        @endif
                    </div>
                </div>
                <div class="card-body expand">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Topic</th>
                                <th>Start Time</th>
                                <th>Duration</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($result->meetings as $key => $meeting)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $meeting->topic }}</td>
                                <td>{{ $meeting->start_time }}</td>
                                <td>{{ $meeting->duration }} mins</td>
                                <td>
                                    @if(auth()->user()->can('meeting.edit'))
                                    <a class="text-danger" href="{{ route('meeting.edit', $meeting->key) }}"><span class="fa fa-edit"></span></a>
                                    @endif
                                    @if(auth()->user()->id == $meeting->user_id)
                                    <a class="text-primary ml-2" title="Start Meeting" href="{{ $meeting->start_url }}" target="_blank"><span class="fa fa-play"></span></a>
                                    @else
                                    <a class="text-primary ml-2" title="Join Meeting" href="{{ $meeting->join_url }}" target="_blank"><span class="fa fa-play"></span></a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3">No meeting found at this moment.</td>
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