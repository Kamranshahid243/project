@extends('layouts.master')
@section('title')
    Products
@endsection
@section('content')
    <div class="row" ng-controller="ProductController">
        <div class="col-sm-12">
            @include('Products.create')
            <div class="box" show-loader="state.loadingProducts">
                <bulk-assigner target="products" url="/products/bulk-edit">
                    <bulk-assigner-field field="bulkAssignerFields.AvailableQuantity">
                        <input type="text" ng-model="bulkAssignerFields.AvailableQuantity.value">
                    </bulk-assigner-field>
                    <bulk-assigner-field field="bulkAssignerFields.UnitPrice">
                        <input type="number" ng-model="bulkAssignerFields.UnitPrice.value">
                    </bulk-assigner-field>
                </bulk-assigner>
                <div class="box-options">
                    <a href="javascript:void(0)" class="box-option"
                       ng-if="products.length">
                        <i to-csv="products"
                           csv-file-name="products.csv"
                           csv-fields="csvFields"
                           class="fa fa-download"
                           uib-tooltip="Download data as CSV"
                           tooltip-placement="left"></i>
                    </a>&nbsp;
                    <a href="javascript:void(0)" ng-click="loadProducts()" class="box-option">
                        <i class="fa fa-sync-alt"
                           uib-tooltip="Reload records"
                           tooltip-placement="left"></i>
                    </a>&nbsp;
                    <bulk-assigner-delete-btn target="products"
                                              url="/products/bulk-delete"
                    ></bulk-assigner-delete-btn>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover grid-view-tbl">
                        <thead>
                        <tr class="search-row">
                            <form class="search-form form-material">
                                <td><input class="form-control" ng-model="state.params.shop_name"/></td>
                                <td><input class="form-control" ng-model="state.params.shop_address"/></td>
                                <td>
                                    <select ng-options="item for item in ['Wholesale','Retail']" class="form-control"
                                            ng-model="state.params.shop_type">
                                        <option value="">Shop Type</option>
                                    </select>
                                </td>
                                <td>
                                    <select ng-options="item for item in ['Thermal','Laser']" class="form-control"
                                            ng-model="state.params.printer_type">
                                        <option value="">Printer Type</option>
                                    </select>
                                </td>
                            </form>
                        </tr>
                        <tr class="header-row">
                            <th>
                                <bulk-assigner-toggle-all target="products"></bulk-assigner-toggle-all>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="product_name"
                                        field-label="Product Name"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="product-code"
                                        field-label="Product Code"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="product_discription"
                                        field-label="Product Description"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="available_quantity"
                                        field-label="Available Quantity"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="unit_price"
                                        field-label="Unit Price"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="product in products"
                            ng-class="{'bg-aqua-active': product.$selected}">
                            <th>
                                <bulk-assigner-checkbox target="product"></bulk-assigner-checkbox>
                            </th>
                            <td>
                                <n-editable type="text" name="product_name"
                                            value="product.product_name"
                                            url="/edit/@{{product.product_id}}"
                                ></n-editable>
                            </td>
                            <td>
                                <n-editable type="text" name="product_code"
                                            value="product.product_code"
                                            url="/edit/@{{product.product_id}}"
                                ></n-editable>
                            </td>
                            <td>
                                <n-editable type="text" name="product_description"
                                            value="product.product_description"
                                            url="/edit/@{{product.product_id}}"
                                ></n-editable>
                            </td>
                            <td>
                                <n-editable type="text" name="available_quantity"
                                            value="product.available_quantity"
                                            url="/edit/@{{product.product_id}}"
                                ></n-editable>
                            </td>
                            <td>
                                <n-editable type="text" name="unit_price"
                                            value="product.unit_price"
                                            url="/edit/@{{product.product_id}}"
                                ></n-editable>
                            </td>
                            <td>
                                <delete-btn action="/deleteProduct/@{{product.product_id}}" on-success="loadProducts()">
                                    <i class="fa fa-trash"></i>
                                </delete-btn>
                            </td>
                        </tr>

                        <tr class="alert alert-warning" ng-if="!products.length && !state.loadingShops">
                            <td colspan="8">No records found.</td>
                        </tr>
                        </tbody>
                    </table>
                    <hr>
                    {{--<pagination state="state" records-info="recordsInfo"></pagination>--}}
                </div>
            </div>
        </div>
    </div>
    <toaster-container></toaster-container>
@endsection
@include('products.product-ng-app')