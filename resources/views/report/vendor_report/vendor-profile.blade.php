@extends("layouts.master")
@section('title') Vendor Stock Report @stop
@section('content')
    <div class="row" ng-controller="VendorProfileController">
        <div class="col-md-3">
            <div class="box box-primary" show-loader="state.loadingVendorsReport">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{Auth::user()->photo}}" alt="User profile picture">
                    <h3 class="profile-username text-center">
                        @{{ profile.vendor_name }}</h3>
                    <p class="text-muted text-center">@{{ profile.vendor_category.cat_name }}</p>
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Name</b>
                            <a class="pull-right">
                                @{{ profile.vendor_name }}
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>Email</b>
                            <a class="pull-right">
                                @{{ profile.vendor_email }}
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>Phone</b>
                            <a class="pull-right">
                                @{{ profile.vendor_phone }}
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>Category</b> <a class="pull-right">@{{ profile.vendor_category.cat_name }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Address</b> <a class="pull-right">
                                @{{ profile.vendor_address }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @include('report.vendor_report.vendor-profile-tabs')
        <toaster-container></toaster-container>
    </div>
@endsection
@include('report.vendor_report.vendor-profile-ng-app')