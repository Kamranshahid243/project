@extends("layouts.master")
@section('title') Orders @stop
@section('content')
    <div class="row" ng-controller="MainController" show-loader="state.loadingOrders">
        <div class="col-sm-12">
            <div align="right">
                <a href="javascript:void(0)" class="box-option"
                   ng-if="orders.length">
                    <i to-csv="orders"
                       csv-file-name="orders.csv"
                       csv-fields="csvFields"
                       class="fa fa-download"
                       uib-tooltip="Download data as CSV"
                       tooltip-placement="left"></i>
                </a>&nbsp;
                <a href="javascript:void(0)" ng-click="Orders()" class="box-option">
                    <i class="fa fa-sync-alt"
                       uib-tooltip="Reload records"
                       tooltip-placement="left"></i>
                </a>&nbsp;
            </div>
            <div class="row" style="background: darkslategray; margin: 0px">
                <div class="col-md-11 col-sm-10" style="padding: 1%;">
                    <input class="form-control" ng-model="state.params.name" placeholder="Search orders"
                           style="border-radius: 5px;"/>
                </div>
                <div class="col-md-1 col-sm-2" style="padding: 1% 0%;">
                    <a href="add-orders">
                        <button class="btn btn-success" name="new_order">New order</button>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12" style="margin: 0px;">
                    <table class="table table-striped">
                        <tr style="background: slategray; color: white; width: 100% !important;">
                            <th>Status</th>
                            <th>Order</th>
                            <th>Customer Name</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Bill ID</th>
                            <th>Qty</th>
                            <th>Actions</th>
                        </tr>
                        <tr ng-repeat="order in orders">
                            <td>
                                @{{ order.order_status }}
                            </td>
                            <td>@{{ order.id }}</td>
                            <td>
                                <n-editable type="select" name="customer_id"
                                            value="order.customer_id"
                                            url="orders/@{{order.id}}"
                                            dd-options="customers"
                                            dd-label-field="customer_name"
                                            dd-value-field="customer_id"
                                ></n-editable>
                            </td>
                            <td>@{{ order.order_status }}</td>
                            <td>@{{ order.order_id }}</td>
                            <td>@{{ order.customer_id }}</td>
                            <td>@{{ order.created_at }}</td>
                            <td>@{{ order.price }}</td>
                            <td>@{{ order.bill_id }}</td>
                            <td>@{{ order.qty }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <toaster-container></toaster-container>
@endsection
@include('order.order-ng-app')
@include('customer.customer-ng-app')