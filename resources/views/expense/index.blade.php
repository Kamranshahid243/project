@extends("layouts.master")
@section('title') Expenses @stop
@section('content')
    <div class="row" ng-controller="MainController" show-loader="state.loadingExpenses">
        <div class="col-sm-12">
            @include('expense.create')
            <div class="box">
                <bulk-assigner target="expenses" url="/expenses/bulk-edit">
                    <bulk-assigner-field field="bulkAssignerFields.category_id">
                        <input type="text" ng-model="bulkAssignerFields.category_id.value">
                    </bulk-assigner-field>
                    <bulk-assigner-field field="bulkAssignerFields.cost">
                        <input type="number" ng-model="bulkAssignerFields.cost.value">
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
                            <form class="search-form form-material">
                                <td><input class="form-control" placeholder="Search by Product Name"
                                           ng-model="state.params.product_name"/></td>
                                <td><input class="form-control" placeholder="Search by Price"
                                           ng-model="state.params.unit_price"/></td>
                                <td>
                                    <select ng-options="item for item in ['active','inactive']" class="form-control"
                                            ng-model="state.params.product_status">
                                        <option value="">Sort status</option>
                                    </select>
                                </td>
                            </form>
                        </tr>
                        <tr class="header-row">
                            <th>
                                <bulk-assigner-toggle-all target="products"></bulk-assigner-toggle-all>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="cat_name"
                                        field-label="Expense"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="cost"
                                        field-label="Cost"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="date"
                                        field-label="Date"
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
                            <td>@{{ expense.expense_category.cat_name }}</td>
                            <td>
                                <n-editable type="text" name="cost"
                                            value="expense.cost"
                                            url="/expenses/@{{expense.id}}"
                                ></n-editable>
                            </td>
                            <td>
                                <n-editable type="date" name="date"
                                            value="expense.date|date:'yyyy-MM-dd'"
                                            url="/expenses/@{{expense.id}}"
                                ></n-editable>
                            </td>
                            <td>
                                <delete-btn action="/expenses/@{{expense.id}}" on-success="loadExpenses()">
                                    <i class="fa fa-trash"></i>
                                </delete-btn>
                            </td>
                        </tr>

                        <tr class="alert alert-warning" ng-if="!expenses.length && !state.loadingExpenses">
                            <td colspan="8">No records found.</td>
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
