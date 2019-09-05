@extends("layouts.master")
@section('title') Dashboard @stop
@push('body-classes') no-content-header @endpush
@section('content')
    <div ng-controller="MainController" ng-show="{{session('shop')}}" show-loader="service.loadingConfig">
        <div class="row">
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
        <div class="box-body bg-danger"
             style="border-radius: 5px;">
            <h2 style="font-family: 'Lobster', cursive;
">Hello Mr. {{Auth::user()->name}}! please select a shop from top right.</h2>
        </div>
    </div>


@endsection
@include('dashboard.dashboard-ng-app')
@include('dashboard.styles')