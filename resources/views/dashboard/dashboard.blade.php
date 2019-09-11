@extends("layouts.master")
@section('title') Dashboard @stop
@push('body-classes') no-content-header @endpush
@section('content')
    <div ng-controller="MainController" ng-show="{{session('shop')}}" show-loader="service.loadingConfig">
        <div class="row" height="700">
            <div class="col-sm-12">
                <nvd-dashboard parent-loader="true" config="dashboardConfig"></nvd-dashboard>
            </div>
        </div>
        @include('dashboard.widgets.users-widget-directive')
        @include('dashboard.info-boxes')
        <br>
        @include('dashboard.charts')
    </div>
    <div class="box" ng-show="!{{session('shop')}}">
        <div class="box-body alert-warning">
            <h2>Hello Mr. {{Auth::user()->name}}! Please select a shop from top right.</h2>
        </div>
    </div>


@endsection
@include('dashboard.dashboard-ng-app')
@include('dashboard.styles')