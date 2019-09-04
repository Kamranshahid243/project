@extends("layouts.master")
@section('title') Expense Categories @stop
@section('content')
    <div class="row" ng-controller="MainController" show-loader="state.loadingExpenseCategories">
        <div class="col-sm-12">
            @include('expense_category.create')
            <div class="box">
                <div class="box-options">
                </div>
                <div class="box-body">
                    <div class="category-div" ng-repeat="category in expenseCategories"
                         ng-class="{'text-danger text-bold':category.status=='Active'}">
                        <n-editable uib-tooltip="@{{ category.status }}" type="text" name="category_name"
                                    value="category.cat_name"
                                    url="/expense-category/@{{category.id}}"
                        ></n-editable>
                        <delete-btn class="pull-right" action="/expense-category/@{{category.id}}"
                                    uib-tooltip="Delete" on-success="loadExpenseCategories()">
                            <i class="fa fa-times" style="color: red;"></i>
                        </delete-btn>
                        <a href="" class="pull-right" uib-tooltip="Enable/Disable"
                           ng-click="changeStatus(category)"><i
                                    class="fa fa-sync-alt"></i>&nbsp</a>
                    </div>
                </div>
            </div>
        </div>
        <toaster-container></toaster-container>
    </div>
@endsection
@include('expense_category.expense-category-ng-app')
@include('expense_category.styles')