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
                                       ng-change="searchProduct(product_name)"
                                       style=" border-radius: 5px;"/>
                            </div>
                        </div>
                    </tr>
                    <tr ng-repeat="product in products| filter:product_name">
                        <td>
                            <h4 ng-class="{'text-muted':product.available_quantity == 0}">@{{ product.product_name
                                }}</h4>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-muted">@{{ product.available_quantity }} in stock</span>
                        </td>
                        <td id="unitPrice" ng-class="{'text-muted': product.available_quantity == 0}">Rs @{{
                            product.unit_price}}
                        </td>
                        <td><a href="" ng-click="addOrder(product)">
                                <i ng-class="{ 'text-muted' : product.available_quantity == 0, 'text-success': product.available_quantity != 0 }"
                                   class="btn1 fas fa-plus-circle pull-right "></i>
                            </a>
                            <br>
                            <span class="text-muted">Category : @{{ product.category.category_name }}</span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6 bill">
                <table class="table table-striped">
                    <tr style="background: slategray; color: white;">
                        <th>Product</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Less Qty</th>
                        <th>Qty</th>
                        <th>Add Qty</th>
                        <th>Erase item</th>
                    </tr>
                    <tr ng-repeat="order in bill">
                        <td>@{{ order.product_name }}</td>
                        <td>Rs @{{ order.unit_price}}</td>
                        <td>Rs @{{ order.unit_price * order.available_quantity}}</td>
                        <td><a href ng-click="lessAction(order)"><i style="font-size: 20px"
                                                                    class="fas fa-minus-circle btn btn-danger"
                                                                    style="font-size: 30px;"></i></a>
                        <td style="font-size: 20px;"><b>@{{ order.available_quantity }}</b></td>
                        <td><a href ng-click="addAction(order)"><i class="fas fa-plus-circle btn btn-success"
                                                                   style="font-size: 20px;"></i></a>
                        </td>
                        <td ng-click="deleteItem(order)"><i cursor="pointer" class="fa fa-trash"
                                                            style="font-size: 30px;"></i></td>
                    </tr>
                    <tr ng-show="bill && bill != 0">
                        <th id="customerBtn" colspan="4" class="text-center">
                            <a class="btn btn-success" ng-click="addCustomer()">Add Customer</a>
                        </th>
                        <th colspan="3" class="text-center">
                            <select class="form-control btn btn-primary" ng-model="AddCustomer" id="addCustomer">
                                <option ng-if="customers.length == 0" value="">Add Customers</option>
                                <option ng-if="customers.length" value="">select customer</option>
                                <option ng-repeat="x in customers"
                                        value="@{{ x }}">
                                    @{{ x.customer_name }}
                                </option>
                            </select>
                        </th>
                    </tr>
                    <tr ng-show="bill && bill != 0">
                        <th class="text-center" style="padding-left: 350px" colspan="7">Total Bill : @{{ totalBill() }}
                        </th>
                    </tr>
                    <tr ng-show="bill && bill != 0">
                        <th class="text-center" colspan="3">Paid:</th>
                        <th colspan="4" id="paid"><input type="number" ng-model="paid"></th>

                    </tr>
                    <tr ng-show="bill && bill != 0">
                        <th class="text-center" colspan="7">
                            <a href class="btn btn-danger" ng-click="clearitems()">Clear Record</a>

                            <a style="margin-left: 250px;" href
                               ng-click="SaleOrder(bill, AddCustomer, Addshop, paid); clearitem()"
                               class="btn btn-success">Continue</a>
                        </th>
                    </tr>
                </table>
                <p ng-if="bill == 0 || !bill" class="alert alert-danger">Your Cart is empty</p>
            </div>
        </div>
    </div>
@endsection
@include('order.order-ng-app')
@include('order.addordder-style')
@include('order.addCusomterModel')