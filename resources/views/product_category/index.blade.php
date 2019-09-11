@extends("layouts.master")
@section('title') Product Categories @stop
@section('content')

    <div class="row" ng-controller="MainController" show-loader="state.loadingCategories">
        <div class="col-sm-12">
            @include('product_category.create')
            <div class="box">
                <div class="box-body">
                    <div class="category-div" ng-repeat="category in productCategories"
                         ng-class="{'text-danger text-bold':category.status=='0'}">
                        <n-editable class="text-bold" type="text" name="category_name"
                                    value="category.category_name"
                                    url="/product-category/@{{category.id}}"
                        ></n-editable>
                        <delete-btn class="pull-right" action="/product-category/@{{category.id}}"
                                    uib-tooltip="Delete" on-success="loadproductCategories()">
                            <i class="fa fa-times" style="color: red;"></i>
                        </delete-btn>
                        <a href="" class="pull-right disable-icon" ng-show="category.status==0"
                           ng-click="changeStatus(category)"><i
                                    class="fa fa-check-circle" uib-tooltip="Category status is disabled"></i>&nbsp</a>
                        <a href="" class="pull-right text-success" ng-show="category.status==1"
                           ng-click="changeStatus(category)"><i
                                    class="fa fa-check-circle" uib-tooltip="Category status is enabled"></i>&nbsp</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@include('product_category.product-category-ng-app')
@include('product_category.styles')