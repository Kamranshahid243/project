@extends("layouts.master")
@section('title') Add Order @stop
@section('content')
    <div class="box" ng-controller="MainController">
        <div class=" row">
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
                        <td><a href="" ng-click="addOrder(product)"><i class="fas fa-plus-circle"
                                                                       style="color:mediumseagreen; font-size: 30px;"></i></a>
                        </td>
                    </tr>
                    {{--<tr>--}}
                    {{--<td>abc</td>--}}
                    {{--<td>def</td>--}}
                    {{--<td style="color:mediumseagreen"><i class="fas fa-plus-circle"></i></td>--}}
                    {{--</tr>--}}
                </table>
            </div>
            <div class="col-md-6">
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
                        <td><a href ng-click="lessAction(order)"><i class="fas fa-minus-circle btn btn-danger"
                                                                    style="font-size: 30px;"></i></a>
                        <td><a href ng-click="addAction(order)"><i class="fas fa-plus-circle btn btn-success"
                                                                   style="font-size: 30px;"></i></a>
                        </td>
                        <td ng-click="lessItem(order)"><i class="fa fa-trash" style="font-size: 30px;"></i></td>
                    </tr>
                    <tr ng-show="bill && bill != 0">
                        <th class="text-center" colspan="3">Total Bill : @{{ totalBill() }}</th>
                        <th colspan="3" href ng-click="clearitems()" class="text-center btn btn-danger">Clear Record
                        </th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
@include('order.order-ng-app')
@include('order.addordder-style')