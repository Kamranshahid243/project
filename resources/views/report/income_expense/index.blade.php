@extends("layouts.master")
@section('title') Income-Expenses Report @stop
@section('content')
    <div class="row" ng-controller="MainController" show-loader="state.loadingExpenses">
        <div class="col-sm-12">
            @include('report.income_expense.create')
            <div class="box" show-loader="state.loadingReport">
                <div class="box-body">
                        <table class="table table-bordered" ng-if="reports && reports.expenses || reports.incomes">
                            <tr ng-show="reports.expenses.length || reports.incomes.length">
                                <th colspan="2" style="text-align: center">Expense</th>
                                <th colspan="2" style="text-align: center">Income</th>
                            </tr>
                            <tr ng-show="reports.expenses.length || reports.incomes.length">
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Category</th>
                                <th>Amount</th>
                            </tr>
                            {{--@{{ reports. }}--}}
                            <tr ng-repeat="report in reports.expenses"
                                ng-show="reports.expenses.length || reports.incomes.length">
    {{--<td>@{{ ($index+1) + " " + $index  }}</td>--}}
                                {{--<td>@{{ report[0].category_id }}</td>--}}
                                <td>@{{ report[0].expense_category.cat_name }}</td>
                                <td>@{{ report[0].total |currency:'PKR '}}</td>
                                <td>@{{ reports.incomes[$index][0].product_category.category_name }}</td>
                                <td>@{{ reports.incomes[$index][0].amount|currency:'PKR ' }}</td>
                            </tr>
                            <tr ng-show="reports.expenses.length || reports.incomes.length">
                                <th>Total</th>
                                <th>@{{ reports.totalExpense|currency:'PKR ' }}</th>
                                <th>Total</th>
                                <th>@{{ reports.totalIncome|currency:'PKR ' }}</th>
                            </tr>
                            <tr ng-show="reports.expenses.length || reports.incomes.length">
                                <th
                                        colspan="4"
                                        class="text-center"
                                        ng-class="{'text-danger':(reports.totalIncome - reports.totalExpense)<0}"
                                >
                                    Net Profit :
                                    @{{ reports.totalIncome - reports.totalExpense|currency:'PKR '}}
                                </th>
                            </tr>
                            <tr class="alert alert-warning"
                                ng-show="!reports.expenses.length && !reports.incomes.length">
                                <td colspan="4">No records found.</td>
                            </tr>
                        </table>
                </div>
            </div>
        </div>
        <toaster-container></toaster-container>
    </div>
@endsection
@include('report.income_expense.income-expense-ng-app')
