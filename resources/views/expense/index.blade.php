@extends("layouts.master")
@section('title') Expenses @stop
@section('content')
    <div class="row" ng-controller="MainController" show-loader="state.loadingExpenses">
        <div class="col-sm-12">
            @include('expense.create')
            <div muna-drag class="box">
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
                    <div class="row">
                        <form class="search-form form-material">
                            <div class="col-sm-5">
                                <label>Quick Date Selector</label><br>
                                <input type="radio" name="dateSelector" ng-change="updateDate()" ng-model="dateSelector"
                                       value="thisMonth" selected><b>This Month</b>&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="dateSelector" ng-change="updateDate()" ng-model="dateSelector"
                                       value="lastMonth"><b>Last Month</b>&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="dateSelector" ng-change="updateDate()" ng-model="dateSelector"
                                       value="currentYear"><b>Current Year</b>
                            </div>
                            <div class="col-sm-7">
                                <table class="table table-bordered table-hover grid-view-tbl">
                                    <thead>
                                    <tr class="search-row">

                                        <td>
                                            <label>Shop</label>
                                            <select class="form-control"
                                                    ng-model="state.params.shop_id">
                                                <option value="">Shop</option>
                                                <option value="@{{ shop.shop_id }}" ng-repeat="shop in allShops"
                                                        ng-show="shop.shop_status=='Active'">@{{ shop.shop_name }}
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <label>Start Date</label>
                                            <input ng-model="startDate" class="form-control" moment-picker="start"
                                                   format="YYYY-MM-DD" min-view="month" max-view="month">
                                        </td>
                                        <td>
                                            <label>End Date</label>
                                            <input ng-model="endDate" class="form-control"
                                                   moment-picker="end" format="YYYY-MM-DD"></td>
                                        <td>
                                            <label style="color:white;">just for leveling td</label>
                                            <button class="btn btn-primary" ng-click="showReport(startDate,endDate)">
                                                Generate Report
                                            </button>
                                        </td>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="box" show-loader="state.loadingReport">
                <div class="box-body" ng-show="reports">
                    <div class="row">
                        <table class="table table-bordered">
                            <tr>
                                <th colspan="2" style="text-align: center">Expense</th>
                                <th colspan="2" style="text-align: center">Income</th>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Category</th>
                                <th>Amount</th>
                            </tr>
                            <tr ng-repeat="report in reports.expenses">
                                <td>@{{ report.expense_category.cat_name }}</td>
                                <td>@{{ report.cost |currency:'PKR '}}</td>
                                <td>@{{ reports.income[$index].name }}</td>
                                <td>@{{ reports.income[$index].cost|currency:'PKR ' }}</td>
                            </tr>
                            <tr ng-if="reports.expenses && reports.income.length">
                                <th>Total</th>
                                <th>@{{ reports.expenses[0].total }}</th>
                                <th>Total</th>
                                <th>@{{ reports.income[0].total }}</th>
                            </tr>
                            <tr ng-if="reports.expenses && reports.income.length">
                                <th
                                        colspan="4"
                                        class="text-center"
                                        ng-class="{'text-danger':(reports.income[0].total -reports.expenses[0].total)<0}"
                                >
                                    Net Profit :
                                    PKR @{{ reports.income[0].total -reports.expenses[0].total}}
                                </th>
                            </tr>
                            <tr class="alert alert-warning" ng-if="!reports.expenses.length && !state.loadingReport">
                                <td colspan="8">No records found.</td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <toaster-container></toaster-container>
    </div>
@endsection
@include('expense.expense-ng-app')
