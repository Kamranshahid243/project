@extends("layouts.master")
@section('title') Add Order @stop
@section('content')
    <div class="box">
        <div class=" row">
            <div class="col-md-6">
                <table class="table table-striped">
                    <tr>
                        <div class="row" style="background: darkslategray; margin: 0px">
                            <div class="col-md-12 col-sm-12" style="padding: 1%;">
                                <input class="form-control" ng-model="state.params.name" placeholder="Search products"
                                       style="border-radius: 5px;"/>
                            </div>
                        </div>

                    </tr>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            <h4>{{ $product->product_name }}</h4>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-muted">{{ $product->available_quantity }} in stock</span>
                        </td>
                        <td>Rs {{$product->unit_price}}</td>
                        <td><a href="" ng-click="addOrder()"><i class="fas fa-plus-circle" style="color:mediumseagreen; font-size: 30px;"></i></a></td>
                    </tr>
                    @endforeach
                    {{--<tr>--}}
                        {{--<td>abc</td>--}}
                        {{--<td>def</td>--}}
                        {{--<td style="color:mediumseagreen"><i class="fas fa-plus-circle"></i></td>--}}
                    {{--</tr>--}}
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-striped">
                    <tr style="background: slategray; color: white;">
                        <th>Qty</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                    <tr>
                        <td>Your Cart is currently empty</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
@include('products.product-ng-app')
@include('order.order-ng-app')
