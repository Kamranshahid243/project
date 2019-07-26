@extends("layouts.master")
@section('title') Expense Categories @stop
@section('content')
    <div class="row" ng-controller="MainController" show-loader="state.loadingExpenseCategories">
        <div class="col-sm-12">
            @include('expense_category.create')
            <div class="box">
                <bulk-assigner target="expenseCategories" url="/expense-category/bulk-edit">
                    <bulk-assigner-field field="bulkAssignerFields.cat_name">
                        <input type="text" ng-model="bulkAssignerFields.cat_name.value" placeholder="Category Name" class="form-control">
                    </bulk-assigner-field>
                    <bulk-assigner-field field="bulkAssignerFields.status">
                        <select ng-options="item for item in ['Active','Inactive']" class="form-control"
                                ng-model="bulkAssignerFields.status.value">
                            <option value="">--Category status--</option>
                        </select>
                    </bulk-assigner-field>
                </bulk-assigner>
                <div class="box-options">
                    <a href="javascript:void(0)" class="box-option"
                       ng-if="expenseCategories.length">
                        <i to-csv="expenseCategories"
                           csv-file-name="expenseCategories.csv"
                           csv-fields="csvFields"
                           class="fa fa-download"
                           uib-tooltip="Download data as CSV"
                           tooltip-placement="left"></i>
                    </a>&nbsp;
                    <a href="javascript:void(0)" ng-click="loadExpenseCategories()" class="box-option">
                        <i class="fa fa-sync-alt"
                           uib-tooltip="Reload records"
                           tooltip-placement="left"></i>
                    </a>&nbsp;
                    <bulk-assigner-delete-btn target="expenseCategories" url="/expense-category/bulk-delete"
                    ></bulk-assigner-delete-btn>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover grid-view-tbl">
                        <thead>
                        <tr class="search-row">
                            <td><b>Search By: </b></td>
                            <form class="search-form form-material">
                                <td><input class="form-control" ng-model="state.params.cat_name" placeholder="Category Name"/>
                                </td>
                                <td>
                                    <select ng-options="item for item in ['Active','Inactive']" class="form-control"
                                            ng-model="state.params.status">
                                        <option value="">Status</option>
                                    </select>
                                </td>
                            </form>
                        </tr>
                        <tr class="header-row">
                            <th>
                                <bulk-assigner-toggle-all target="expenseCategories"></bulk-assigner-toggle-all>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="cat_name"
                                        field-label="Category"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="status"
                                        field-label="Status"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="expenseCategory in expenseCategories"
                            ng-class="{'bg-aqua-active': expenseCategory.$selected}">
                            <th>
                                <bulk-assigner-checkbox target="expenseCategory"></bulk-assigner-checkbox>
                            </th>
                            <td>
                                <n-editable type="text" name="cat_name"
                                            value="expenseCategory.cat_name"
                                            url="/expense-category/@{{expenseCategory.id}}"
                                ></n-editable>
                            </td>
                            <td ng-show="expenseCategory.status=='Active'" style="color: green; font-weight: bold;">
                                <n-editable type="select" name="status"
                                            value="expenseCategory.status"
                                            url="/expense-category/@{{expenseCategory.id}}"
                                            dd-options="[{o:'Active'},{o:'Inactive'}]"
                                            dd-label-field="o"
                                            dd-value-field="o"
                                ></n-editable>
                            </td>
                            <td ng-show="expenseCategory.status=='Inactive'" style="color: red; font-weight: bold;">
                                <n-editable type="select" name="status"
                                            value="expenseCategory.status"
                                            url="/expense-category/@{{expenseCategory.id}}"
                                            dd-options="[{o:'Active'},{o:'Inactive'}]"
                                            dd-label-field="o"
                                            dd-value-field="o"
                                ></n-editable>
                            </td>
                            <td>
                                <delete-btn action="/expense-category/@{{expenseCategory.id}}" on-success="loadExpenseCategories()">
                                    <i class="fa fa-trash"></i>
                                </delete-btn>
                            </td>
                        </tr>
                        <tr class="alert alert-warning" ng-if="!expenseCategories.length && !state.loadingExpenseCategories">
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
@include('expense_category.expense-category-ng-app')
