@extends("layouts.master")
@section('title') Add Order @stop
@section('content')
    <div class="box" ng-controller="MainController">
        <div class="row">

            <div class="col-md-6 products">
                <table class="table table-striped" show-loader="state.loadingProducts">
                    <tr>
                        <div class="row" style="background: darkslategray; margin: 0px">
                            <div class="col-md-12 col-sm-12" style="padding: 1%;">
                                <input class="form-control" ng-model="product_name"
                                       placeholder="Search products"
                                       style="border-radius: 5px;"/>
                            </div>
                        </div>
                    </tr>
                    <tr ng-repeat="product in products| filter:product_name">
                        <td>
                            <h4>@{{ product.product_name }}</h4>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-muted">@{{ product.available_quantity }} in stock</span>
                        </td>
                        <td>Rs @{{ product.unit_price}}</td>
                        <td><a href="" ng-click="addOrder(product)">
                                <i class="fas fa-plus-circle" style="color:mediumseagreen; font-size: 30px;"></i>
                            </a>
                        </td>
                    </tr>
                    {{--<tr>--}}
                    {{--<td>abc</td>--}}
                    {{--<td>def</td>--}}
                    {{--<td style="color:mediumseagreen"><i class="fas fa-plus-circle"></i></td>--}}
                    {{--</tr>--}}
                </table>
            </div>
            <div class="col-md-6 bill">
                <table class="table table-striped" show-loader="state.loadProducts">
                    <tr style="background: slategray; color: white;">
                        <th>Qty</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Less Qty</th>
                        <th>Add Qty</th>
                        <th>Erase item</th>
                    </tr>
                    <tr ng-repeat="order in bill">
                        <td>@{{ order.available_quantity }}</td>
                        <td>@{{ order.product_name }}</td>
                        <td>Rs @{{ order.unit_price}}</td>
                        <td>Rs @{{ order.unit_price * order.available_quantity}}</td>
                        <td><a href ng-click="lessAction(order)"><i style="font-size: 30px"
                                                                    class="fas fa-minus-circle btn btn-danger"
                                                                    style="font-size: 30px;"></i></a>
                        <td><a href ng-click="addAction(order)"><i class="fas fa-plus-circle btn btn-success"
                                                                   style="font-size: 30px;"></i></a>
                        </td>
                        <td ng-click="deleteItem(order)"><i cursor="pointer" class="fa fa-trash"
                                                            style="font-size: 30px;"></i></td>
                    </tr>
                    <tr ng-show="bill && bill != 0">
                        <th colspan="3" class="text-center">
                            <h4>Add Customers</h4>
                        </th>
                        <th colspan="4" class="text-center">
                            <select class="form-control" ng-model="Addcustomers" style="margin-top: 8px;" id="">
                                <option selected value="">Please Select</option>
                                <option ng-repeat="x in customers"
                                        value="@{{ x.customer_id }}">
                                    @{{ x.customer_name }}
                                </option>
                            </select>
                        </th>
                    </tr>
                    <tr ng-show="bill && bill != 0">
                        <th colspan="3" class="text-center">
                            <h4>Add Shop</h4>
                        </th>
                        <th colspan="4" class="text-center">
                            <select class="form-control" ng-model="Addshop" style="margin-top: 8px;" id="">
                                <option selected value="">Please Select</option>
                                <option ng-repeat="x in shops"
                                        value="@{{ x }}">
                                    @{{ x.shop_name }}
                                </option>
                            </select>
                        </th>
                    </tr>
                    <tr ng-show="bill && bill != 0">
                        <th class="text-center" colspan="2">
                            <a href class="btn btn-danger" ng-click="clearitems()">Clear Record</a>
                        </th>
                        <th class="text-center" colspan="5">Total Bill : @{{ totalBill() }}</th>
                    </tr>
                    <tr ng-show="bill && bill != 0">
                        <th colspan="7" class="text-center">
                            <a style="margin-left: 300px;" href ng-click="SaleOrder(bill, Addcustomers,Addshop)"
                               class="btn btn-success">Continue</a>
                        </th>
                    </tr>
                </table>
                <p ng-if="bill == 0 || !bill" class="alert alert-danger">Your Cart is empty
                <p>
            </div>
        </div>
    </div>
@endsection
@include('order.order-ng-app')
@include('order.addordder-style')