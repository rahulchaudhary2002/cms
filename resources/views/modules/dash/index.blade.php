@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item">Dashboard</li>
</ul>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="item-icon">
                                <span class="fa fa-users text-success"></span>
                            </div>
                            <div class="item-title">
                                Students
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="v-line"></div>
                        </div>
                        <div class="col-md-5">
                            <div class="item-number">
                                15000
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="item-icon">
                                <span class="fa fa-users text-warning"></span>
                            </div>
                            <div class="item-title">
                                Teachers
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="v-line"></div>
                        </div>
                        <div class="col-md-5">
                            <div class="item-number">
                                1000
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="item-icon">
                                <span class="fa fa-users text-danger"></span>
                            </div>
                            <div class="item-title">
                                Parents
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="v-line"></div>
                        </div>
                        <div class="col-md-5">
                            <div class="item-number">
                                8000
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="item-icon">
                                <span class="fa fa-money-bill-1 text-primary"></span>
                            </div>
                            <div class="item-title">
                                Total Earnings
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="v-line"></div>
                        </div>
                        <div class="col-md-5">
                            <div class="item-number">
                                &dollar;950000
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header d-flex-space-between">
                    <h1 class="card-title">Notice Board</h1>
                    <div class="card-setting d-flex gap-2">
                        <a class="text-warning card-body-collapsed" href="#"><span class="fa fa-angle-down"></span></a>
                        <a class="text-success card-refresh" href="#"><span class="fa fa-rotate"></span></a>
                        <a class="text-danger card-collapsed" href="#"><span class="fa fa-xmark"></span></a>
                    </div>
                </div>
                <div class="card-body expand notice-board">
                    <div class="row mb-2">
                        <div class="col-md-12 col-sm-12 line-height-2">
                            <strong class="f-7 text-success">Rahul Chaudhary</strong>
                            <small class="text-gray">9 min ago</small>
                        </div>
                        <div class="col-md-12 col-sm-12 line-height-normal">
                            <p>Lorem Ipsum is a long established fact that a reader will be distracted by the
                                readable content of a page when looking at its layout.</p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12 col-sm-12 line-height-2">
                            <strong class="f-7 text-primary">Rahul Chaudhary</strong>
                            <small class="text-gray">9 min ago</small>
                        </div>
                        <div class="col-md-12 col-sm-12 line-height-normal">
                            <p>Lorem Ipsum is a long established fact that a reader will be distracted by the
                                readable content of a page when looking at its layout.</p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12 col-sm-12 line-height-2">
                            <strong class="f-7 text-warning">Rahul Chaudhary</strong>
                            <small class="text-gray">9 min ago</small>
                        </div>
                        <div class="col-md-12 col-sm-12 line-height-normal">
                            <p>Lorem Ipsum is a long established fact that a reader will be distracted by the
                                readable content of a page when looking at its layout.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 line-height-2">
                            <strong class="f-7 text-danger">Rahul Chaudhary</strong>
                            <small class="text-gray">9 min ago</small>
                        </div>
                        <div class="col-md-12 col-sm-12 line-height-normal">
                            <p>Lorem Ipsum is a long established fact that a reader will be distracted by the
                                readable content of a page when looking at its layout.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex-space-between">
                    <h1 class="card-title">Event Calender</h1>
                    <div class="card-setting d-flex gap-2">
                        <a class="text-warning card-body-collapsed" href="#"><span class="fa fa-angle-down"></span></a>
                        <a class="text-success card-refresh" href="#"><span class="fa fa-rotate"></span></a>
                        <a class="text-danger card-collapsed" href="#"><span class="fa fa-xmark"></span></a>
                    </div>
                </div>
                <div class="card-body expand">
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
