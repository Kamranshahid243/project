@extends('layouts.master')
@section('title')
    Vendors
@endsection
@section('content')
    <div class="row" ng-controller="VendorController">
        <div class="col-sm-12">
            @include('vendor.create')
            <div class="box" show-loader="state.loadingVendors">
                <bulk-assigner target="vendors" url="/vendors/bulk-edit">
                    <bulk-assigner-field field="bulkAssignerFields.Vendorname">
                        <input type="text" ng-model="bulkAssignerFields.Vendorname.value">
                    </bulk-assigner-field>
                    <bulk-assigner-field field="bulkAssignerFields.vendorStatus">
                        <select ng-options="item for item in ['active','inactive']" class="form-control"
                                ng-model="bulkAssignerFields.vendorStatus.value">
                            <option value="">Sort status</option>
                        </select>
                    </bulk-assigner-field>
                </bulk-assigner>
                <div class="box-options">
                    <a href="javascript:void(0)" class="box-option"
                       ng-if="vendors.length">
                        <i to-csv="vendors"
                           csv-file-name="vendors.csv"
                           csv-fields="csvFields"
                           class="fa fa-download"
                           uib-tooltip="Download data as CSV"
                           tooltip-placement="left"></i>
                    </a>&nbsp;
                    <a hr ef="javascript:void(0)" ng-click="loadVendors()" class="box-option">
                        <i class="fa fa-sync-alt"
                           uib-tooltip="Reload records"
                           tooltip-placement="left"></i>
                    </a>&nbsp;
                    <bulk-assigner-delete-btn target="vendors"
                                              url="/vendors/bulk-delete"
                    ></bulk-assigner-delete-btn>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover grid-view-tbl">
                        <thead>
                        <tr class="search-row">
                            <form class="search-form form-material">
                                <td><input class="form-control" placeholder="Search by Name"
                                           ng-model="state.params.vendor_name"/></td>
                                <td><input class="form-control" placeholder="Search by Email"
                                           ng-model="state.params.vendor_email"/></td>
                                <td>
                                    <select ng-options="item for item in ['active','inactive']" class="form-control"
                                            ng-model="state.params.vendor_status">
                                        <option value="">Sort status</option>
                                    </select>
                                </td>
                            </form>
                        </tr>
                        <tr class="header-row">
                            <th>
                                <bulk-assigner-toggle-all target="vendors"></bulk-assigner-toggle-all>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="shop_id"
                                        field-label="Shop id"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="vendor_name"
                                        field-label="Vendor Name"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="vendor_address"
                                        field-label="Vendor Address"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="vendor_phone"
                                        field-label="Vendor Phone"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="vendor_email"
                                        field-label="Vendor Email"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="vendor_status"
                                        field-label="Vendor Status"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="vendor in vendors"
                            ng-class="{'bg-aqua-active': vendor.$selected}">
                            <th>
                                <bulk-assigner-checkbox target="vendor"></bulk-assigner-checkbox>
                            </th>
                            <td>
                                <n-editable type="text" name="shop_id"
                                            value="vendor.shop_id"
                                            url="/edit/@{{vendor.vendor_id}}"
                                ></n-editable>
                            </td>
                            <td>
                                <n-editable type="text" name="vendor_name"
                                            value="vendor.vendor_name"
                                            url="/edit/@{{vendor.vendor_id}}"
                                ></n-editable>
                            </td>
                            <td>
                                <n-editable type="text" name="vendor_address"
                                            value="vendor.vendor_address"
                                            url="/edit/@{{vendor.vendor_id}}"
                                ></n-editable>
                            </td>
                            <td>
                                <n-editable type="text" name="vendor_phone"
                                            value="vendor.vendor_phone"
                                            url="/edit/@{{vendor.vendor_id}}"
                                ></n-editable>
                            </td>
                            <td>
                                <n-editable type="text" name="vendor_email"
                                            value="vendor.vendor_email"
                                            url="/edit/@{{vendor.vendor_id}}"
                                ></n-editable>
                            </td>
                            <td>
                                <n-editable type="select" name="vendor_status"
                                            value="vendor.vendor_status"
                                            url="/edit/@{{vendor.vendor_id}}"
                                            dd-options="[{i:'active'},{i:'inactive'}]"
                                            dd-label-field="i"
                                            dd-value-field="i"
                                ></n-editable>
                            </td>
                            <td>
                                <delete-btn action="/deleteVendor/@{{vendor.vendor_id}}" on-success="loadVendors()">
                                    <i class="fa fa-trash"></i>
                                </delete-btn>
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
@include('vendor.vendor-ng-app')