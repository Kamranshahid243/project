@extends("layouts.master")
@section('title') Reciept @stop
@section('content')
    <link type="text/css" rel="stylesheet"
          href="{{URL::asset('assets/administrator/bootstrap/css/bootstrap.min.css')}}">
    <div class="box" ng-controller="MainController">
        <div class="row">
            <div class="products">
                <h1 class="text-center">Shop Name: {{session('shop')->shop_name}}</h1>
                <div class="header col-sm-5">
                    <table class="table header-table table-responsive table-bordered" align="right">
                        <tr>
                            <th class="table-head">Invoice Number</th>
                            <td class="text-center">@{{data.id}}</td>
                        </tr>
                        <tr>
                            <th class="table-head">Customer Name</th>
                            <td class="text-center">@{{data.customer.customer_name}}</td>
                        </tr>
                        <tr>
                            <th class="table-head">Customer Address</th>
                            <td class="text-center">@{{ data.customer.customer_address }}</td>
                        </tr>
                        <tr>
                            <th class="table-head">Date</th>
                            <td class="text-center">@{{ data.date}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="proInfo col-lg-12">
                <table class="table table-border-less">
                    <tr>
                        <th class="table-head text-center">Product Name</th>
                        <th class="table-head text-center">Product Price</th>
                        <th class="table-head text-center">Product Desc</th>
                    </tr>
                    <tbody ng-repeat="item in data.order">
                    <tr>
                        <td class="text-center">@{{item.product.product_name}}</td>
                        <td class="text-center">@{{item.product.unit_price}}</td>
                        <td class="text-center">@{{item.product.product_description}}</td>
                    </tr>
                    </tbody>
                    <tr>
                        <td colspan="1" class="table-head">Total: @{{ data.total }}</td>
                        <td colspan="1" class="table-head">Paid Amount: @{{ data.paid }}</td>
                        <td colspan="1" class="table-head">Pending Amount: @{{ data.total - data.paid }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
@include('order.receipt-ng-app')
@include('order.reciept-styles')