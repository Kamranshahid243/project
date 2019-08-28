@extends("layouts.master")
@section('title') Dashboard @stop
@push('body-classes') no-content-header @endpush
@section('content')
    <div class="row" ng-controller="MainController">
        <div class="col-sm-12">
            <nvd-dashboard config="dashboardConfig"></nvd-dashboard>
        </div>
    </div>
    @include('dashboard.widgets.users-widget-directive')
    @include('dashboard.info-boxes')
    <br>
    @include('dashboard.charts')
        <script>

    </script>
@endsection
@include('dashboard.dashboard-ng-app')
@include('dashboard.styles')