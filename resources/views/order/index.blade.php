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
            <div class="row" style="background: darkslategray; margin: 0px; padding-right: 10px;">
                <div class="col-md-11 col-sm-10" style="padding: 1%;">
                    <input type="text" class="form-control" placeholder="Search Order"
                           ng-model="state.params.customer_name">
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
                        {{--<pre>@{{ orders | json }}</pre>--}}
                        <tr ng-repeat="order in orders">
                            <td style="color: orange" ng-show="order.order_status == 'Pending'">
                                <i uib-tooltip="@{{order.order_status}}" class="far fa-clock"></i>
                            </td>
                            <td style="color: blue" ng-show="order.order_status == 'Paid'">
                                <i uib-tooltip="@{{order.order_status}}" class="far fa-check-circle"></i></td>
                            <td>

                                <n-editable type="select" name="customer_id"
                                            value="order.customer_id"
                                            url="orders/@{{order.id}}"
                                            dd-options="customers"
                                            dd-label-field="customer_name"
                                            dd-value-field="customer_id"
                                ></n-editable>
                            </td>
                            <td>PKR: @{{ order.price }}</td>
                            <td>
                                <n-editable type="text" name="paid"
                                            value="order.paid"
                                            url="orders/@{{order.id}}"
                                ></n-editable>
                            </td>
                            <td ng-if="order.price - order.paid">PKR: @{{ order.price - order.paid }}</td>
                            <td ng-if="!(order.price - order.paid)"><span class="text-bold text-green">Paid</span></td>
                            <td>@{{ order.qty }}</td>
                            <td>@{{ order.date| nvdDate:"mediumDate" }}</td>
                            <td><a type="submit" class="btn btn-success">View Bill</a></td>
                        </tr>
                    </table>
                </div>
                <pagination state="state" records-info="recordsInfo"></pagination>

            </div>
        </div>
    </div>
    <toaster-container></toaster-container>
@endsection
@include('order.order-ng-app')