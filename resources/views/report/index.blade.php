@extends("layouts.master")
@section('title') Income-Expenses Report @stop
@section('content')
    <div class="row" ng-controller="MainController" show-loader="state.loadingExpenses">
        <div class="col-sm-12">
            @include('report.create')
            <div class="box" show-loader="state.loadingReport">
                <div class="box-body">
                    <div class="row">
                        <table class="table table-bordered"
                               ng-if="reports.expenses.length && reports.incomes.length">
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
                            {{--@{{ reports. }}--}}
                            <tr ng-repeat="report in reports.expenses">
    {{--<td>@{{ ($index+1) + " " + $index  }}</td>--}}
                                {{--<td>@{{ report[0].category_id }}</td>--}}
                                <td>@{{ report[0].expense_category.cat_name }}</td>
                                <td>@{{ report[0].total |currency:'PKR '}}</td>
                                <td>@{{ reports.incomes[$index+1][$index].product_category.category_name }}</td>
                                <td>@{{ reports.incomes[$index+1][0].amount|currency:'PKR ' }}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <th>@{{ reports.totalExpense|currency:'PKR ' }}</th>
                                <th>Total</th>
                                <th>@{{ reports.totalIncome|currency:'PKR ' }}</th>
                            </tr>
                            <tr ng-if="reports.expenses && reports.incomes">
                                <th
                                        colspan="4"
                                        class="text-center"
                                        ng-class="{'text-danger':(reports.totalIncome - reports.totalExpense)<0}"
                                >
                                    Net Profit :
                                    @{{ reports.totalIncome - reports.totalExpense|currency:'PKR '}}
                                </th>
                            </tr>
                        </table>
                    </div>
                    <br>
                    <div class="alert alert-warning"
                         ng-if="reports && !reports.expenses.length && !reports.incomes.length && !state.loadingReport">
                        <p>No records found.</p>
                    </div>
                </div>
            </div>
        </div>
        <toaster-container></toaster-container>
    </div>
@endsection
@include('report.income-expense-ng-app')
