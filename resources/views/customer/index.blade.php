@extends("layouts.master")
@section('title') Customers @stop
@section('content')
    <div class="row" ng-controller="MainController" show-loader="state.loadingCustomers">
        <div class="col-sm-12">
            @include('customer.create')
            <div class="box">
                <bulk-assigner target="customers" url="/customers/bulk-edit">
                    <bulk-assigner-field field="bulkAssignerFields.customer_type">
                        <select ng-options="item for item in ['Shopkeeper','Consumer']" class="form-control"
                                ng-model="bulkAssignerFields.customer_type.value">
                            <option value="">Customer Type</option>
                        </select>
                    </bulk-assigner-field>
                    <bulk-assigner-field field="bulkAssignerFields.shop_id">
                        <select class="form-control"
                                ng-model="bulkAssignerFields.shop_id.value">
                            <option value="">Shop</option>
                            <option value="@{{ x.shop_id }}" ng-repeat="x in allShops">@{{ x.shop_name }}</option>
                        </select>
                    </bulk-assigner-field>
                </bulk-assigner>
                <div class="box-options">
                    <a href="javascript:void(0)" class="box-option"
                       ng-if="customers.length">
                        <i to-csv="customers"
                           csv-file-name="customers.csv"
                           csv-fields="csvFields"
                           class="fa fa-download"
                           uib-tooltip="Download data as CSV"
                           tooltip-placement="left"></i>
                    </a>&nbsp;
                    <a href="javascript:void(0)" ng-click="loadCustomers()" class="box-option">
                        <i class="fa fa-sync-alt"
                           uib-tooltip="Reload records"
                           tooltip-placement="left"></i>
                    </a>&nbsp;
                    <bulk-assigner-delete-btn target="customers"
                                              url="/customers/bulk-delete"
                    ></bulk-assigner-delete-btn>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover grid-view-tbl">
                        <thead>
                        <tr class="search-row">
                            <td></td>
                            <form class="search-form form-material">
                                <td><input class="form-control" ng-model="state.params.customer_name"/></td>
                                <td><input class="form-control" ng-model="state.params.customer_email"/></td>
                                <td>
                                    <select ng-options="item for item in ['Enabled','Disabled']" class="form-control"
                                            ng-model="state.params.status">
                                        <option value="">Shop</option>
                                    </select>
                                </td>
                                <td>
                                    <select ng-options="item for item in ['Shopkeeper','Consumer']" class="form-control"
                                            ng-model="state.params.customer_type">
                                        <option value="">Customer Type</option>
                                    </select>
                                </td>
                                <td></td>
                            </form>
                        </tr>
                        <tr class="header-row">
                            <th>
                                <bulk-assigner-toggle-all target="customers"></bulk-assigner-toggle-all>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="customer_name"
                                        field-label="Customer"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="shop_name"
                                        field-label="Shop"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="customer_email"
                                        field-label="Email"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="customer_type"
                                        field-label="Customer Type"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="customer_address"
                                        field-label="Address"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="customer_phone"
                                        field-label="Phone"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="customer in customers"
                            ng-class="{'bg-aqua-active': customer.$selected}">
                            <th>
                                <bulk-assigner-checkbox target="customer"></bulk-assigner-checkbox>
                            </th>
                            <td>
                                <n-editable type="text" name="customer_name"
                                            value="customer.customer_name"
                                            url="/customers/@{{customer.customer_id}}"
                                ></n-editable>
                            </td>
                            <td>@{{ customer.shop_name }}
                                <n-editable type="text" name="shop_name"
                                            value="customer.shop.shop_name"
                                            url="/customers/@{{customer.customer_id}}"
                                ></n-editable>
                            </td>
                            <td>
                                <n-editable type="text" name="customer_email"
                                value="customer.customer_email"
                                url="/customers/@{{customer.customer_id}}"
                                ></n-editable>
                            </td>
                            <td>
                                <n-editable type="select" name="customer_type"
                                            value="customer.customer_type"
                                            url="/customers/@{{customer.customer_id}}"
                                            dd-options="[{o:'Shopkeeper'},{o:'Consumer'}]"
                                            dd-label-field="o"
                                            dd-value-field="o"
                                ></n-editable>
                            </td>
                            <td>
                                <n-editable type="text" name="customer_address"
                                            value="customer.customer_address"
                                            url="/customers/@{{customer.customer_id}}"
                                ></n-editable>
                            </td>
                            <td>
                                <n-editable type="text" name="customer_phone"
                                            value="customer.customer_phone"
                                            url="/customers/@{{customer.customer_id}}"
                                ></n-editable>
                            </td>
                            <td>
                                <delete-btn action="/customers/@{{customer.customer_id}}" on-success="loadCustomers()">
                                    <i class="fa fa-trash"></i>
                                </delete-btn>
                            </td>
                        </tr>

                        <tr class="alert alert-warning" ng-if="!customers.length && !state.loadingCustomers">
                            <td colspan="6">No records found.</td>
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
@include('customer.customer-ng-app')