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
                        <n-editable uib-tooltip="@{{ category.status }}" type="text" name="category_name"
                                    value="category.category_name"
                                    url="/product-category/@{{category.id}}"
                        ></n-editable>
                        <delete-btn class="pull-right" action="/product-category/@{{category.id}}"
                                    uib-tooltip="Delete" on-success="loadproductCategories()">
                            <i class="fa fa-times" style="color: red;"></i>
                        </delete-btn>
                        <a href="" class="pull-right" uib-tooltip="Change status"
                           ng-click="changeStatus(category)"><i
                                    class="fa fa-sync-alt"></i>&nbsp</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@include('product_category.product-category-ng-app')
@include('product_category.styles')