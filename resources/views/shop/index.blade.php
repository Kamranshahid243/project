@extends("layouts.master")
@section('title') Shops @stop
@section('content')
    <div class="row" ng-controller="MainController" show-loader="state.loadingShops">
        <div class="col-sm-
        12">
            @include('shop.create')
            <div class="box">

                <bulk-assigner target="shopsArray" url="/shops/bulk-edit">
                    <bulk-assigner-field field="bulkAssignerFields.shopType">
                        <select ng-options="item for item in ['Wholesale','Retail']" class="form-control"
                                ng-model="bulkAssignerFields.shopType.value">
                            <option value="">Shop Type</option>
                        </select>
                    </bulk-assigner-field>
                    <bulk-assigner-field field="bulkAssignerFields.printerType">
                        <select ng-options="item for item in ['Thermal','laser']" class="form-control"
                                ng-model="bulkAssignerFields.printerType.value">
                            <option value="">Printer Type</option>
                        </select>
                    </bulk-assigner-field>
                </bulk-assigner>
                <div class="box-options">
                    <a href="javascript:void(0)" class="box-option"
                       ng-if="shopsArray.length">
                        <i to-csv="shopsArray"
                           csv-file-name="shopsArray.csv"
                           csv-fields="csvFields"
                           class="fa fa-download"
                           uib-tooltip="Download data as CSV"
                           tooltip-placement="left"></i>
                    </a>&nbsp;
                    <a href="javascript:void(0)" ng-click="loadShops()" class="box-option">
                        <i class="fa fa-sync-alt"
                           uib-tooltip="Reload records"
                           tooltip-placement="left"></i>
                    </a>&nbsp;
                    <bulk-assigner-delete-btn target="shopsArray"
                                              url="/shops/bulk-delete"
                    ></bulk-assigner-delete-btn>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover grid-view-tbl">
                        <thead>
                        <tr class="header-row">
                            <th>
                                <bulk-assigner-toggle-all target="shopsArray"></bulk-assigner-toggle-all>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="shop_name"
                                        field-label="Shop Name"
                                        model="state.params"
                                        search-field="true"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="shop_address"
                                        field-label="Shop Address"
                                        model="state.params"
                                        search-field="true"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="shop_type"
                                        field-label="Shop Type"
                                        model="state.params"
                                        search-field="true"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="printer_type"
                                        field-label="Printer Type"
                                        model="state.params"
                                        search-field="true"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="shop_type"
                                        field-label="Shop Status"
                                        model="state.params"
                                        search-field="true"
                                ></filter-btn>
                            </th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="shop in shopsArray"
                            ng-class="{'bg-aqua-active': shop.$selected}">
                            <th>
                                <bulk-assigner-checkbox target="shop"></bulk-assigner-checkbox>
                            </th>
                            <td>
                                <n-editable type="text" name="shop_name"
                                            value="shop.shop_name"
                                            url="/shops/@{{shop.shop_id}}"
                                ></n-editable>
                            </td>
                            <td>
                                <n-editable type="text" name="shop_address"
                                            value="shop.shop_address"
                                            url="/shops/@{{shop.shop_id}}"
                                ></n-editable>
                            </td>
                            <td>
                                <n-editable type="select" name="shop_type"
                                            value="shop.shop_type"
                                            url="/shops/@{{shop.shop_id}}"
                                            dd-options="[{o:'Wholesale'},{o:'Retail'}]"
                                            dd-label-field="o"
                                            dd-value-field="o"
                                ></n-editable>
                            </td>
                            <td>
                                <n-editable type="select" name="printer_type"
                                            value="shop.printer_type"
                                            url="/shops/@{{shop.shop_id}}"
                                            dd-options="[{o:'Thermal'},{o:'Laser'}]"
                                            dd-label-field="o"
                                            dd-value-field="o"
                                ></n-editable>
                            </td>
                            <td ng-if="shop.shop_status=='Active'" style="color: green; font-weight: bold;">
                                <n-editable type="select" name="shop_status"
                                            value="shop.shop_status"
                                            url="/shops/@{{shop.shop_id}}"
                                            dd-options="[{o:'Active'},{o:'Inactive'}]"
                                            dd-label-field="o"
                                            dd-value-field="o"
                                ></n-editable>
                            </td>
                            <td ng-if="shop.shop_status=='Inactive'" style="color: red; font-weight: bold;">
                                <n-editable type="select" name="shop_status"
                                            value="shop.shop_status"
                                            url="/shops/@{{shop.shop_id}}"
                                            dd-options="[{o:'Active'},{o:'Inactive'}]"
                                            dd-label-field="o"
                                            dd-value-field="o"
                                ></n-editable>
                            </td>
                            <th>
                                <delete-btn action="/shops/@{{shop.shop_id}}" on-success="loadShops()">
                                    <i class="fa fa-trash"></i>
                                </delete-btn>
                            </th>
                        </tr>

                        <tr class="alert alert-warning" ng-if="!shopsArray.length && !state.loadingShops">
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
@include('shop.shop-ng-app')