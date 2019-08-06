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
                                <th colspan="3" class="text-center">
                                    Income
                                </th>
                                <th colspan="3" class="text-center">Expenses</th>
                            </tr>
                            <tr>
                                <th class="text-center">Product Name</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Date</th>
                            </tr>
                            <tr ng-repeat="income in incomes">
                                <td class="text-center">@{{ income.product_name }}</td>
                                <td class="text-center">@{{ income.price }}</td>
                                <td class="text-center">@{{ income.date }}</td>
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