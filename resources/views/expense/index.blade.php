@extends("layouts.master")
@section('title') Expenses @stop
@section('content')
    <div class="row" ng-controller="MainController" show-loader="state.loadingExpenses">
        <div class="col-sm-12">
            @include('expense.create')
            <div class="box">
                <bulk-assigner target="expenses" url="/expenses/bulk-edit">
                    <bulk-assigner-field field="bulkAssignerFields.date">
                        <input type="date" ng-model="bulkAssignerFields.date.value">
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
                        <tr class="header-row">
                            <th>
                                <bulk-assigner-toggle-all target="expenses"></bulk-assigner-toggle-all>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="category_id"
                                        field-label="Expense"
                                        options="allCategories"
                                        option-label-field="cat_name"
                                        option-value-field="id"
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
