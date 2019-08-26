@extends("layouts.master")
@section('title') Product Summary Report @stop
@section('content')
    <div class="row" ng-controller="MainController" show-loader="state.loadingExpenses">
        <div class="col-sm-12">
            @include('report.product_summary.create')
            <div class="box" show-loader="state.loadingProductsReport">
                <div class="box-body">
                    <table class="table table-bordered grid-view-tbl">
                        <thead>
                        <tr class="header-row">
                            <th>
                                <filter-btn
                                        field-name="product_name"
                                        field-label="Product"
                                        search-field='true'
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="category_name"
                                        field-label="Category"
                                        search-field='true'
                                        model="state.params"

                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="qty"
                                        field-label="Quantity"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="customer_name"
                                        field-label="Total Income"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="product in reportProducts">

                                <td>
                                    @{{ product.product_name }}
                                </td>
                                <td>@{{ product.category.category_name }}</td>
                                <td>@{{ product.totalQty + " Pcs" }}</td>
                                <td>@{{ product.totalPrice|currency:'PKR ' }}</td>
                                <td>
                                    @{{ product[0].maxProduct[0] }}
                                </td>
                            </tr>
                        <tr>
                            <td>
                                @{{ productsReports.maxProduct[0].products.product_name }}
                            </td>
                            <td>
                                @{{ productsReports.minProduct[0].products.product_name }}
                            </td>
                        </tr>
                            <tr class="alert alert-warning" ng-if="!reportProducts.length && !state.loadingProductsReport">
                                <td colspan="8">No records found.</td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <pagination state="state" records-info="recordsInfo"></pagination>
                </div>
            </div>
        </div>
        <toaster-container></toaster-container>
    </div>
@endsection
@include('report.product_summary.product-summary-ng-app')
