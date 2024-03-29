@extends("layouts.master")
@section('title') Vendor Categories @stop
@section('content')
    <div class="row" ng-controller="MainController" show-loader="state.loadingVendorCategories">
        <div class="col-sm-12">
            @include('vendor_category.create')
            <div class="box">
                <div class="box-body">
                    <div class="category-div" ng-repeat="vendorCategory in vendorCategories"
                    ng-class="{'text-danger text-bold':vendorCategory.status=='0'}">
                    <n-editable class="text-bold" type="text" name="cat_name"
                                value="vendorCategory.cat_name"
                                url="/vendor-category/@{{vendorCategory.id}}"
                    ></n-editable>
                    <delete-btn class="pull-right" action="/vendor-category/@{{vendorCategory.id}}"
                                on-success="loadVendorCategories()">
                        <i class="fa fa-times" style="color: red;"></i>
                    </delete-btn>
                    <a href="" class="pull-right disable-icon" ng-show="vendorCategory.status==0"
                       ng-click="vendorCatStatus(vendorCategory.id)"><i class="fa fa-check-circle"
                                                                        uib-tooltip="Category status is disabled"></i>&nbsp;</a>
                    <a href="" class="pull-right text-success" ng-show="vendorCategory.status==1"
                       ng-click="vendorCatStatus(vendorCategory.id)"><i class="fa fa-check-circle text-secondary"
                                                                        uib-tooltip="Category status is enabled"></i>&nbsp;</a>
                </div>
                <div class="alert alert-warning" ng-if="!vendorCategories.length && !state.loadingVendorCategories">
                    No records found.
                </div>
            </div>
        </div>
    </div>
    <toaster-container></toaster-container>
    </div>
@endsection
@include('vendor_category.vendor-category-ng-app')
@include('vendor_category.styles')