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
                <a href="javascript:void(0)" ng-click="loadOrders()" class="box-option">
                    <i class="fa fa-sync-alt"
                       uib-tooltip="Reload records"
                       tooltip-placement="left"></i>
                </a>&nbsp;
            </div>
            <div class="row" style="background: darkslategray; margin: 0px; padding-right: 10px;">
                <div class="col-md-11 col-sm-10" style="padding: 1%;">
                    <input type="text" class="form-control" placeholder="Search Order"
                           ng-model="customer_name" ng-change="searchBill(customer_name)">
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
                            <th>Customer Name</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Pending Amount</th>
                            <th>Qty</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                        <tr ng-repeat="bill in orders | filter:customer_name ">
                            <td>
                                <i ng-show="@{{ totalprice(bill.order) > bill.paid }}" uib-tooltip="Pending"
                                   class="far fa-clock"
                                   style="color: orange"></i>

                                <i ng-show="@{{ totalprice(bill.order) == bill.paid }}" uib-tooltip="Paid"
                                   class="far fa-check-circle"
                                   style="color: blue"></i>
                            </td>
                            <td>
                                <n-editable type="select" name="customer_id"
                                            value="bill.customer.customer_id"
                                            url="/updateOrders/@{{ bill.id }}"
                                            dd-options="customers"
                                            dd-label-field="customer_name"
                                            dd-value-field="customer_id"
                                ></n-editable>
                            </td>
                            <td>PKR: @{{ totalprice(bill.order) }}</td>
                            <td>
                                <n-editable type="text" name="paid" on-success="loadOrders()" value="bill.paid"
                                            url="/bills/@{{ bill.id }}">
                                </n-editable>
                            </td>
                            <td ng-show="@{{ (totalprice(bill.order) - bill.paid) == 0}}"
                                class="text-success text-bold">Paid
                            </td>
                            <td ng-show="@{{ (totalprice(bill.order) - bill.paid) != 0 }}">
                                PKR: @{{
                                totalprice(bill.order) - bill.paid }}
                            </td>
                            <td>@{{ totalQty(bill.order) }}</td>
                            <td>@{{ bill.date| nvdDate:"mediumDate" }}</td>
                            <td><a class="btn btn-success"
                                   ng-click="orderDetail(bill)">View Bill</a>
                            </td>
                        </tr>
                    </table>
                </div>
                <pagination state="state" records-info="recordsInfo"></pagination>
            </div>
        </div>
    </div>
    <toaster-container></toaster-container>
@endsection
@include('order.orderDetails')
@include('order.order-ng-app')