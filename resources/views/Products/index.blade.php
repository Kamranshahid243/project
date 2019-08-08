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
                                <td>
                                    <select ng-options="item for item in ['Available','Unavailable']"
                                            class="form-control"
                                            ng-model="state.params.product_status">
                                        <option value="">Sort status</option>
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
                                        search-field="true"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="product_code"
                                        field-label="Product Code"
                                        model="state.params"
                                        search-field="true"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="product_category"
                                        field-label="Product Category"
                                        model="state.params"
                                        search-field="true"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="product_description"
                                        field-label="Product Description"
                                        model="state.params"
                                        search-field="true"
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
                            <th>
                                <filter-btn
                                        field-name="product_status"
                                        field-label="Product Status"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--<pre>@{{ products | json }}</pre>--}}
                        <tr ng-repeat="product in products"
                            ng-class="{'bg-aqua-active': product.$selected,'bg-danger text-bold':product.available_quantity<=10}">
                            <th>
                                <bulk-assigner-checkbox target="product"></bulk-assigner-checkbox>
                            </th>
                            <td>
                                <n-editable type="text" name="product_name"
                                            value="product.product_name"
                                            url="/editProducts/@{{product.product_id}}"
                                ></n-editable>
                            </td>
                            <td>
                                <n-editable type="text" name="product_code"
                                            value="product.product_code"
                                            url="/editProducts/@{{product.product_id}}"
                                ></n-editable>
                            </td>
                            <td>
                                @{{ product.category.category_name }}
                            </td>
                            <td>
                                <n-editable type="text" name="product_description"
                                            value="product.product_description"
                                            url="/editProducts/@{{product.product_id}}"
                                ></n-editable>
                            </td>
                            <td>@{{ product.available_quantity }}</td>
                            <td>PKR
                                <n-editable type="text" name="unit_price"
                                            value="product.unit_price"
                                            url="/editProducts/@{{product.product_id}}"
                                ></n-editable>
                            </td>
                            <td ng-class="{'text-success text-bold':product.product_status=='Available','text-danger text-bold':product.product_status=='Unavailable'}">
                                <n-editable type="select" name="product_status"
                                            value="product.product_status"
                                            url="/editProducts/@{{product.product_id}}"
                                            dd-options="[{i:'Available'},{i:'Unavailable'}]"
                                            dd-label-field="i"
                                            dd-value-field="i"
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
                    <pagination state="state" records-info="recordsInfo"></pagination>
                </div>
            </div>
        </div>
    </div>
    <toaster-container></toaster-container>
@endsection
@include('products.product-ng-app')