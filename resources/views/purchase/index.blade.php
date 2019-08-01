@extends('layouts.master')
@section('title')
    Purchases
@endsection
@section('content')
    <div class="row" ng-controller="MainController">
        <div class="col-sm-12">
            @include('purchase.create')
            <div class="box" show-loader="state.loadingPurchases">
                <bulk-assigner target="purchases" url="/purchases/bulk-edit">
                    <bulk-assigner-field field="bulkAssignerFields.date">
                        <input type="date" ng-model="bulkAssignerFields.date.value">
                    </bulk-assigner-field>
                </bulk-assigner>
                <div class="box-options">
                    <a href="javascript:void(0)" class="box-option"
                       ng-if="purchases.length">
                        <i to-csv="purchases"
                           csv-file-name="purchases.csv"
                           csv-fields="csvFields"
                           class="fa fa-download"
                           uib-tooltip="Download data as CSV"
                           tooltip-placement="left"></i>
                    </a>&nbsp;
                    <a href="javascript:void(0)" ng-click="loadPurchases()" class="box-option">
                        <i class="fa fa-sync-alt"
                           uib-tooltip="Reload records"
                           tooltip-placement="left"></i>
                    </a>&nbsp;
                    <bulk-assigner-delete-btn target="purchases"
                                              url="/purchases/bulk-delete"
                    ></bulk-assigner-delete-btn>
                </div>
                <div class="box-body">
                    <table class="table table-bordered grid-view-tbl">
                        <thead>
                        <tr class="search-row">
                            <td><label>Search By:</label></td>
                            <form class="search-form form-material">
                                <td>
                                    <select class="form-control"
                                            ng-model="state.params.vendor_id">
                                        <option value="@{{ vendor.vendor_id }}" ng-repeat="vendor in vendors" ng-show="vendor.vendor_status=='Enabled'">@{{ vendor.vendor_name }}</option>
                                        <option value="">Vendor Name</option>
                                    </select>
                                </td>
                                <td><input class="form-control" placeholder="Product Name"
                                           ng-model="state.params.product_name"/></td>
                            </form>
                        </tr>
                        <tr class="header-row">
                            <th>
                                <bulk-assigner-toggle-all target="purchases"></bulk-assigner-toggle-all>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="vendor_id"
                                        field-label="Vendor"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="product_name"
                                        field-label="Product"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="paid"
                                        field-label="Paid"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="payable"
                                        field-label="Payable"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="total"
                                        field-label="Total"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="date"
                                        field-label="Date"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr ng-repeat="purchase in purchases"
                            ng-class="{'bg-aqua-active': purchase.$selected}">
                            <th>
                                <bulk-assigner-checkbox target="purchase"></bulk-assigner-checkbox>
                            </th>
                            <td>
                                @{{ purchase.vendor.vendor_name }}
                            </td>
                            <td>
                                <n-editable type="text" name="product_name"
                                            value="purchase.product_name"
                                            url="/purchases/@{{purchase.id}}"
                                ></n-editable>
                            </td>
                            <td>PKR
                                <n-editable type="text" name="paid"
                                            value="purchase.paid"
                                            url="/purchases/@{{purchase.id}}"
                                ></n-editable>
                            </td>
                            <td>@{{ purchase.payable|currency:'PKR ' }}</td>
                            <td>@{{ purchase.total|currency:'PKR ' }}</td>
                            <td>
                                <n-editable type="date" name="date"
                                            value="purchase.date"
                                            url="/purchases/@{{purchase.id}}"
                                ></n-editable>
                            </td>
                            <td>
                                <a href="#" ng-click="purchaseModal(purchase)"><i class="fa fa-folder-open"></i></a>
                                <delete-btn action="/purchases/@{{purchase.id}}" on-success="loadPurchases()">
                                    <i class="fa fa-trash"></i>
                                </delete-btn>
                            </td>
                        </tr>

                        <tr class="alert alert-warning" ng-if="!purchases.length && !state.loadingPurchases">
                            <td colspan="8">No records found.</td>
                        </tr>
                        </tbody>
                    </table>
                    <hr>
                    <pagination state="state" records-info="recordsInfo"></pagination>
                </div>
            </div>
        </div>

        {{--modal--}}
        <script type="text/ng-template" id="myModalContent.html">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title">Purchase Details</h3>
            </div>
            <div class="modal-body" id="modal-body">
                <div class="row">
                    <div class="col-md-2 col-sm-2"></div>
                    <div class="col-md-8 col-sm-8">
                        <table class="table">
                            <tr>
                                <th>Vendor:</th>
                                <td>@{{ item.vendor.vendor_name }}</td>
                            </tr>
                            <tr>
                                <th>Product:</th>
                                <td>@{{ item.product_name }}</td>
                            </tr>
                            <tr>
                                <th>Vendor Phone:</th>
                                <td>@{{ item.vendor.vendor_phone }}</td>
                            </tr>
                            <tr>
                                <th>Quantity:</th>
                                <td>@{{ item.quantity }}</td>
                            </tr>
                            <tr>
                                <th>Product Net Cost:</th>
                                <td>@{{ item.original_cost|currency:'PKR ' }}</td>
                            </tr>
                            <tr>
                                <th>Puchasing Cost:</th>
                                <td>@{{ item.purchase_cost|currency:'PKR ' }}</td>
                            </tr>
                            <tr>
                                <th>Selling Cost:</th>
                                <td>@{{ item.customer_cost|currency:'PKR ' }}</td>
                            </tr>
                            <tr>
                                <th>Total Cost:</th>
                                <td>
                                    @{{ item.total|currency:'PKR ' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Paid:</th>
                                <td>@{{ item.paid }}</td>
                            </tr>
                            <tr>
                                <th>Payable:</th>
                                <td>
                                    @{{ item.payable|currency:'PKR ' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Date:</th>
                                <td>
                                    @{{ item.date }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" ng-click="cancel()">Cancel</button>
            </div>
        </script>
    </div>
    <toaster-container></toaster-container>
@endsection
@include('purchase.purchase-ng-app')