@extends("layouts.master")
@section('title') Shops @stop
@section('content')
    <div class="row" ng-controller="MainController" show-loader="state.loadingShops">
        <div class="col-sm-12">
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
                                              url="/shop/bulk-delete"
                    ></bulk-assigner-delete-btn>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover grid-view-tbl">
                        <thead>
                        <tr class="search-row">
                            <td></td>
                            <form class="search-form form-material">
                                <td><input class="form-control" ng-model="state.params.shop_name"/></td>
                                <td><input class="form-control" ng-model="state.params.shop_address"/></td>
                                <td>
                                    <select ng-options="item for item in ['Wholesale','Retail']" class="form-control"
                                            ng-model="state.params.shop_type">
                                        <option value="">Shop Type</option>
                                    </select>
                                </td>
                                <td>
                                    <remote-select
                                            url="/printer-type"
                                            ng-model="state.params.printer_type"
                                            label-field="printer_type" value-field="shop_id"
                                            placeholder="Printer Type"
                                    ></remote-select>
                                </td>
                                <td></td>
                            </form>
                        </tr>
                        <tr class="header-row">
                            <th>
                                <bulk-assigner-toggle-all target="shopsArray"></bulk-assigner-toggle-all>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="shop_name"
                                        field-label="Shop Name"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="shop_address"
                                        field-label="Shop Address"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="shop_type"
                                        field-label="Shop Type"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="printer_type"
                                        field-label="Printer Type"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="shop in shopsArray"
                            ng-class="{'bg-aqua-active': user.$selected}">
                            <th>
                                <bulk-assigner-checkbox target="user"></bulk-assigner-checkbox>
                            </th>
                            <td>
                                <n-editable type="text" name="shop_name"
                                            value="shop.shop_name"
                                            url="/shop/@{{shop.shop_id}}"
                                ></n-editable>
                            </td>
                            <td>
                                <n-editable type="text" name="shop_address"
                                value="shop.shop_address"
                                url="/shop/@{{shop.shop_id}}"
                                ></n-editable>
                            </td>
                            <td>
                                <n-editable type="select" name="shop_type"
                                            value="shop.shop_type"
                                            url="/shop/@{{shop.shop_id}}"
                                            dd-options="[{o:'Wholesale'},{o:'Retail'}]"
                                            dd-label-field="o"
                                            dd-value-field="o"
                                ></n-editable>
                            </td>
                            <td>
                                <n-editable type="select" name="printer_type"
                                            value="shop.printer_type"
                                            url="/shop/@{{shop.shop_id}}"
                                            dd-options="[{o:'Thermal'},{o:'Laser'}]"
                                            dd-label-field="o"
                                            dd-value-field="o"
                                ></n-editable>
                            </td>
                            <td>
                                <delete-btn action="/shop/@{{shop.shop_id}}" on-success="loadShops()">
                                    <i class="fa fa-trash"></i>
                                </delete-btn>
                            </td>
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