@extends("layouts.master")
@section('title') Income-Expenses Report @stop
@section('content')
    <div class="row" ng-controller="MainController" show-loader="state.loadingExpenses">
        <div class="col-sm-12">
            @include('report.create')
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
                            @{{ reports }}
                            <tr ng-repeat="report in reports.expenses">

                                <td>@{{ report.expense_category.cat_name }}</td>
                                <td>@{{ report.cost |currency:'PKR '}}</td>
                                <td>@{{ reports.income[$index].name }}</td>
                                <td>@{{ reports.income[$index].cost|currency:'PKR ' }}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <th>@{{ reports.totalCost|currency:'PKR ' }}</th>
                                <th>Total</th>
                                <th>@{{ reports.income[0].total|currency:'PKR ' }}</th>
                            </tr>
                            <tr ng-if="reports.expenses && reports.income.length">
                                <th
                                        colspan="4"
                                        class="text-center"
                                        ng-class="{'text-danger':(reports.income[0].total -reports.totalCost)<0}"
                                >
                                    Net Profit :
                                    @{{ reports.income[0].total -reports.totalCost|currency:'PKR '}}
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
@include('report.income-expense-ng-app')
