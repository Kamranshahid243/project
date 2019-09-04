@extends('layouts.master')
@section('title')
    Vendor Stock Report
@endsection
@section('content')
    <div class="row" ng-controller="VendorReportController">
        <div class="col-sm-12 box" >
                <div class="box-body" show-loader="state.loadingVendors">
                    <table class="table table-bordered table-hover grid-view-tbl">
                        <thead>
                        <tr class="search-row">
                        </tr>
                        <tr class="header-row">
                            <th>
                                <filter-btn
                                        field-name="vendor_name"
                                        field-label="Vendor Name"
                                        model="state.params"
                                        search-field="true"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="v_cat_id"
                                        field-label="Category"
                                        model="state.params"
                                        search-field="true"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="vendor_phone"
                                        field-label="Vendor Phone"
                                        model="state.params"
                                        search-field="true"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="vendor_email"
                                        field-label="Vendor Email"
                                        model="state.params"
                                        search-field="true"
                                ></filter-btn>
                            </th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="vendor in vendors"
                            ng-class="{'bg-aqua-active': vendor.$selected}">
                            <td>@{{ vendor.vendor_name }}</td>
                            <td>@{{ vendor.vendor_category.cat_name }}</td>
                            <td>@{{ vendor.vendor_phone }}</td>
                            <td>@{{ vendor.vendor_email }}</td>
                            <td>
                                <a href="vendor-detail-page?id=@{{ vendor.vendor_id }}"><i class="fa fa-folder-open"></i></a>
                            </td>
                        </tr>

                        <tr class="alert alert-warning" ng-if="!vendors.length && !state.loadingVendors">
                            <td colspan="8">No records found.</td>
                        </tr>
                        </tbody>
                    </table>
                    <hr>
                    <pagination state="state" records-info="recordsInfo"></pagination>
                </div>
            </div>
        </div>
    </div>
    <toaster-container></toaster-container>
@endsection
@include('report.vendor_report.vendor-report-ng-app')