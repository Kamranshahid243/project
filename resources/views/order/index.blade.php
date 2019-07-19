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
           {{--<div class="box-options">--}}
           {{--@include('order.create')--}}
           {{--<div class="box">--}}
           <div class="row" style="background: darkslategray; margin: 0px">
               <div class="col-md-11 col-sm-10" style="padding: 1%;">
                   <input class="form-control" ng-model="state.params.name" placeholder="Search orders"
                          style="border-radius: 5px;"/>
               </div>
               <div class="col-md-1 col-sm-2" style="padding: 1% 0%;">
                   <a href="add-orders">
                       <button class="btn btn-success" name="new_order">New order</button></a>

               </div>
           </div>

           <div class="row">
               <div class="col-sm-12" style="margin: 0px;">
                   <table class="table table-striped">
                       <tr style="background: slategray; color: white; width: 100% !important;">
                           <th></th>
                           <th>Status</th>
                           <th>Order</th>
                           <th>Customer</th>
                           <th>Date</th>
                           <th>Total</th>
                           <th>Actions</th>
                           <th></th>
                           <th></th>
                       </tr>
                       <tr>
                           <td></td>
                           <td style="color: cornflowerblue; font-size: 20px;"><i class="far fa-check-circle"></i></td>
                           <td>70242</td>
                           <td>Kamran</td>
                           <td>08 Jul 1996 02:00pm</td>
                           <td>Rs 2000</td>
                           <td><input type="submit" value="View" class="btn btn-success btn-sm"></td>
                           <td></td>
                           <td></td>
                       </tr>
                       <tr>
                           <td></td>
                           <td style="color: sandybrown; font-size: 20px;"><i
                                       class="far fa-clock"></i></td>
                           <td>70242</td>
                           <td>Kamran</td>
                           <td>08 Jul 1996 02:00pm</td>
                           <td>Rs 2000</td>
                           <td><input type="submit" value="View" class="btn btn-success btn-sm"></td>
                           <td></td>
                           <td></td>
                       </tr>
                   </table>
               </div>
           </div>
           </div>

       </div>

        {{--<div class="col-sm-12">--}}
            {{--@include('order.create')--}}
            {{--<div class="box">--}}
                {{--<bulk-assigner target="orders" url="/orders/bulk-edit">--}}
                    {{--<bulk-assigner-field field="bulkAssignerFields.status">--}}
                        {{--<select ng-options="item for item in ['Enabled','Disabled']" class="form-control"--}}
                                {{--ng-model="bulkAssignerFields.status.value">--}}
                            {{--<option value="">Status</option>--}}
                        {{--</select>--}}
                    {{--</bulk-assigner-field>--}}
                    {{--<bulk-assigner-field field="bulkAssignerFields.user_role_id">--}}
                        {{--<remote-select--}}
                                {{--url="/order-role"--}}
                                {{--ng-model="bulkAssignerFields.user_role_id.value"--}}
                                {{--label-field="role" value-field="id"--}}
                                {{--placeholder="User Role"--}}
                        {{--></remote-select>--}}
                    {{--</bulk-assigner-field>--}}
                {{--</bulk-assigner>--}}
                {{--<div class="box-options">--}}
                    {{--<a href="javascript:void(0)" class="box-option"--}}
                       {{--ng-if="orders.length">--}}
                        {{--<i to-csv="orders"--}}
                           {{--csv-file-name="orders.csv"--}}
                           {{--csv-fields="csvFields"--}}
                           {{--class="fa fa-download"--}}
                           {{--uib-tooltip="Download data as CSV"--}}
                           {{--tooltip-placement="left"></i>--}}
                    {{--</a>&nbsp;--}}
                    {{--<a href="javascript:void(0)" ng-click="loadOrders()" class="box-option">--}}
                        {{--<i class="fa fa-sync-alt"--}}
                           {{--uib-tooltip="Reload records"--}}
                           {{--tooltip-placement="left"></i>--}}
                    {{--</a>&nbsp;--}}
                    {{--<bulk-assigner-delete-btn target="orders"--}}
                                              {{--url="/orders/bulk-delete"--}}
                    {{--></bulk-assigner-delete-btn>--}}
                {{--</div>--}}
                {{--<div class="box-body">--}}
                    {{--<table class="table table-bordered table-hover grid-view-tbl">--}}
                        {{--<thead>--}}
                        {{--<tr class="search-row">--}}
                            {{--<td></td>--}}
                            {{--<form class="search-form form-material">--}}
                                {{--<td><input class="form-control" ng-model="state.params.name"/></td>--}}
                                {{--<td><input class="form-control" ng-model="state.params.email"/></td>--}}
                                {{--<td>--}}
                                    {{--<select ng-options="item for item in ['Enabled','Disabled']" class="form-control"--}}
                                            {{--ng-model="state.params.status">--}}
                                        {{--<option value="">Status</option>--}}
                                    {{--</select>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<remote-select--}}
                                        {{--url="/user-role"--}}
                                        {{--ng-model="state.params.user_role_id"--}}
                                        {{--label-field="role" value-field="id"--}}
                                        {{--placeholder="User Role"--}}
                                    {{--></remote-select>--}}
                                {{--</td>--}}
                                {{--<td></td>--}}
                            {{--</form>--}}
                        {{--</tr>--}}
                        {{--<tr class="header-row">--}}
                            {{--<th>--}}
                                {{--<bulk-assigner-toggle-all target="orders"></bulk-assigner-toggle-all>--}}
                            {{--</th>--}}
                            {{--<th>--}}
                                {{--<filter-btn--}}
                                        {{--field-name="customer_name"--}}
                                        {{--field-label="Customer Name"--}}
                                        {{--model="state.params"--}}
                                {{--></filter-btn>--}}
                            {{--</th>--}}
                            {{--<th>--}}
                                {{--<filter-btn--}}
                                        {{--field-name="customer_phone"--}}
                                        {{--field-label="Phone"--}}
                                        {{--model="state.params"--}}
                                {{--></filter-btn>--}}
                            {{--</th>--}}
                            {{--<th>--}}
                                {{--<filter-btn--}}
                                        {{--field-name="total_price"--}}
                                        {{--field-label="Total Price"--}}
                                        {{--model="state.params"--}}
                                {{--></filter-btn>--}}
                            {{--</th>--}}
                            {{--<th>--}}
                                {{--<filter-btn--}}
                                        {{--field-name="paid"--}}
                                        {{--field-label="Paid"--}}
                                        {{--model="state.params"--}}
                                {{--></filter-btn>--}}
                            {{--</th>--}}
                            {{--<th>--}}
                                {{--<filter-btn--}}
                                        {{--field-name="remainig"--}}
                                        {{--field-label="Remaining"--}}
                                        {{--model="state.params"--}}
                                {{--></filter-btn>--}}
                            {{--</th>--}}
                            {{--<th>--}}
                                {{--<filter-btn--}}
                                        {{--field-name="status"--}}
                                        {{--field-label="Status"--}}
                                        {{--model="state.params"--}}
                                {{--></filter-btn>--}}
                            {{--</th>--}}
                            {{--<th>Action</th>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody>--}}
                        {{--<tr ng-repeat="order in orders"--}}
                            {{--ng-class="{'bg-aqua-active': order.$selected}">--}}
                            {{--<th>--}}
                                {{--<bulk-assigner-checkbox target="orders"></bulk-assigner-checkbox>--}}
                            {{--</th>--}}
                            {{--<td>--}}
                                {{--<n-editable type="text" name="name"--}}
                                            {{--value="order.order_id"--}}
                                            {{--url="/orders/@{{order.order_id}}"--}}
                                {{--></n-editable>--}}
                            {{--</td>--}}
                            {{--<td>@{{ order.email }}--}}
                                {{--<n-editable type="text" name="email"--}}
                                            {{--value="user.email"--}}
                                            {{--url="/user/@{{user.id}}"--}}
                                {{--></n-editable>--}}
                            {{--</td>--}}
                            {{--<td>--}}
                                {{--<n-editable type="select" name="status"--}}
                                            {{--value="order.status"--}}
                                            {{--url="/orders/@{{order.order_id}}"--}}
                                            {{--dd-options="[{o:'Enabled'},{o:'Disabled'}]"--}}
                                            {{--dd-label-field="o"--}}
                                            {{--dd-value-field="o"--}}
                                {{--></n-editable>--}}
                            {{--</td>--}}
                            {{--<td>--}}
                                {{--<n-editable type="select" name="user_role_id"--}}
                                            {{--value="order.user_role_id"--}}
                                            {{--url="/orders/@{{order.order_id}}"--}}
                                            {{--dd-options-url="/user-role"--}}
                                            {{--dd-label-field="role"--}}
                                            {{--dd-value-field="id"--}}
                                {{--></n-editable>--}}
                            {{--</td>--}}
                            {{--<td>--}}
                                {{--<delete-btn action="/orders/@{{order.order_id}}" on-success="loadOrders()">--}}
                                    {{--<i class="fa fa-trash"></i>--}}
                                {{--</delete-btn>--}}
                            {{--</td>--}}
                        {{--</tr>--}}

                        {{--<tr class="alert alert-warning" ng-if="!orders.length && !state.loadingOrders">--}}
                            {{--<td colspan="6">No records found.</td>--}}
                        {{--</tr>--}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                    {{--<hr>--}}
                    {{--<pagination state="state" records-info="recordsInfo"></pagination>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        <toaster-container></toaster-container>
    </div>
@endsection
@include('order.order-ng-app')
@include('customer.customer-ng-app')