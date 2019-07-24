@extends("layouts.master")
@section('title') Expenses @stop
@section('content')
    <div class="row" ng-controller="MainController" show-loader="state.loadingExpenses">
        <div class="col-sm-12">
            @include('expense.create')
            <div class="box">
                <bulk-assigner target="expenses" url="/expenses/bulk-edit">
                    <bulk-assigner-field field="bulkAssignerFields.shop_id">
                        <select class="form-control"
                                ng-model="bulkAssignerFields.shop_id.value">
                            <option value="">Shop</option>
                            <option value="@{{ shop.shop_id }}" ng-repeat="shop in allShops" ng-show="shop.shop_status=='Active'">@{{ shop.shop_name }}</option>
                        </select>
                    </bulk-assigner-field>
                    <bulk-assigner-field field="bulkAssignerFields.rent">
                        <input type="number" ng-model="bulkAssignerFields.rent.value">
                    </bulk-assigner-field>
                    <bulk-assigner-field field="bulkAssignerFields.salaries">
                        <input type="number" ng-model="bulkAssignerFields.salaries.value">
                    </bulk-assigner-field>
                    <bulk-assigner-field field="bulkAssignerFields.refreshment">
                        <input type="number" ng-model="bulkAssignerFields.refreshment.value">
                    </bulk-assigner-field>
                    <bulk-assigner-field field="bulkAssignerFields.drawing">
                        <input type="number" ng-model="bulkAssignerFields.drawing.value">
                    </bulk-assigner-field>
                    <bulk-assigner-field field="bulkAssignerFields.loss">
                        <input type="number" ng-model="bulkAssignerFields.loss.value">
                    </bulk-assigner-field>
                    <bulk-assigner-field field="bulkAssignerFields.bills">
                        <input type="number" ng-model="bulkAssignerFields.bills.value">
                    </bulk-assigner-field>
                    <bulk-assigner-field field="bulkAssignerFields.others">
                        <input type="number" ng-model="bulkAssignerFields.others.value">
                    </bulk-assigner-field>
                </bulk-assigner>
                <div class="box-options">
                    <a href="javascript:void(0)" class="box-option"
                       ng-if="expenses.length">
                        <i to-csv="expenses"
                           csv-file-name="expenses.csv"
                           csv-fields="csvFields"
                           class="fa fa-download"
                           uib-tooltip="Download data as CSV"
                           tooltip-placement="left"></i>
                    </a>&nbsp;
                    <a href="javascript:void(0)" ng-click="loadExpenses()" class="box-option">
                        <i class="fa fa-sync-alt"
                           uib-tooltip="Reload records"
                           tooltip-placement="left"></i>
                    </a>&nbsp;
                    <bulk-assigner-delete-btn target="expenses"
                                              url="/expenses/bulk-delete"
                    ></bulk-assigner-delete-btn>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover grid-view-tbl">
                        <thead>
                        <tr class="search-row">
                            <td></td>
                            <form class="search-form form-material">
                                <td>
                                    <select class="form-control"
                                            ng-model="state.params.shop_id">
                                        <option value="">Shop</option>
                                        <option value="@{{ shop.shop_id }}" ng-repeat="shop in allShops" ng-show="shop.shop_status=='Active'">@{{ shop.shop_name }}</option>
                                    </select>
                                </td>

                            </form>
                        </tr>
                        <tr class="header-row">
                            <th>
                                <bulk-assigner-toggle-all target="expenses"></bulk-assigner-toggle-all>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="shop_id"
                                        field-label="Shop"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="rent"
                                        field-label="Rent"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="salaries"
                                        field-label="Salaries"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="refreshment"
                                        field-label="Refreshment"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="drawing"
                                        field-label="drawing"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="loss"
                                        field-label="Loss"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="bills"
                                        field-label="Bills"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="others"
                                        field-label="Others"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="total"
                                        field-label="Total"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="created_at"
                                        field-label="Month"
                                        model="state.params"
                                ></filter-btn>
                            </th>

                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="expense in expenses"
                            ng-class="{'bg-aqua-active': expense.$selected}">
                            <th>
                                <bulk-assigner-checkbox target="expense"></bulk-assigner-checkbox>
                            </th>
                            <td>
                                {{--<n-editable type="select" name="shop_id"--}}
                                            {{--value="expense.shop_name"--}}
                                            {{--url="/expense/@{{expense.expense_id}}"--}}
                                            {{--dd-options-url="/get-shops"--}}
                                            {{--dd-label-field="shop_id"--}}
                                            {{--dd-value-field="shop_id"--}}
                                {{--></n-editable>--}}
                                {{--<select class="form-control" ng-model="expense.shop_id">--}}
                                    {{--<option value="" ng-repeat="shop in allShops">@{{ shop.shop_name }}</option>--}}
                                {{--</select>--}}
                            <span ng-repeat="shop in allShops" ng-show="shop.shop_id==expense.shop_id">@{{ shop.shop_name }}</span>
                            </td>
                            <td>Rs
                                <n-editable type="text" name="rent"
                                            value="expense.rent"
                                            url="/expenses/@{{expense.expense_id}}"
                                ></n-editable>
                            </td>
                            <td>Rs
                                <n-editable type="text" name="salaries"
                                value="expense.salaries"
                                url="/expenses/@{{expense.expense_id}}"
                                ></n-editable>
                            </td>
                            <td>Rs
                                <n-editable type="text" name="refreshment"
                                            value="expense.refreshment"
                                            url="/expenses/@{{expense.expense_id}}"
                                ></n-editable>
                            </td>
                            <td>Rs
                                <n-editable type="text" name="drawing"
                                            value="expense.drawing"
                                            url="/expenses/@{{expense.expense_id}}"
                                ></n-editable>
                            </td>

                            <td>Rs
                                <n-editable type="text" name="loss"
                                            value="expense.loss"
                                            url="/expenses/@{{expense.expense_id}}"
                                ></n-editable>
                            </td>

                            <td>Rs
                                <n-editable type="text" name="bills"
                                            value="expense.bills"
                                            url="/expenses/@{{expense.expense_id}}"
                                ></n-editable>
                            </td>

                            <td>Rs
                                <n-editable type="text" name="others"
                                            value="expense.others"
                                            url="/expenses/@{{expense.expense_id}}"
                                ></n-editable>
                            </td>
                            <td>
                                <span>Rs @{{ expense.rent + expense.salaries + expense.refreshment + expense.drawing + expense.loss + expense.bills + expense.others }}</span>
                            </td>
                            <td>
                                <span>@{{ expense.created_at |nvdDate:"MMM-y" }}</span>
                            </td>

                            <td>
                                <delete-btn action="/expenses/@{{expense.expense_id}}" on-success="loadExpenses()">
                                    <i class="fa fa-trash"></i>
                                </delete-btn>
                            </td>
                        </tr>

                        <tr class="alert alert-warning" ng-if="!expenses.length && !state.loadingExpenses">
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
@include('expense.expense-ng-app')
