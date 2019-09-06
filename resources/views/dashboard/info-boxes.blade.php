<div class="row" ng-controller="MainController"  ng-show="{{session('shop')}}">
    <div class="col-md-4 col-sm-6" ng-show="topProduct">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">

                <h3>@{{ topProduct.maxQtyProduct.product_name }}</h3>
                <p>Top Seller Quantity (@{{ topProduct.maxQuantity + " Pcs)" }}</p>
            </div>
            <div class="icon">
                <i class="fab fa-product-hunt"></i>
            </div>
            {{--<a href="#" class="small-box-footer">--}}
            {{--More info <i class="fa fa-arrow-circle-right"></i>--}}
            {{--</a>--}}
        </div>
    </div>
    <div class="col-md-4 col-sm-6" ng-show="topProduct">
        <!-- small box -->
        <div class="small-box bg-aqua" style="background: rgba(102,204,102,1) !important;">
            <div class="inner">
                <h3>@{{ topProduct.maxProfitProduct.product_name }}</h3>
                <p>Top Seller Profit (@{{ topProduct.maxProfit |currency:'PKR ' }})</p>
            </div>
            <div class="icon">
                <i class="fab fa-product-hunt"></i>
            </div>
            {{--<a href="#" class="small-box-footer">--}}
            {{--More info <i class="fa fa-arrow-circle-right"></i>--}}
            {{--</a>--}}
        </div>
    </div>
    <div class="col-md-4 col-sm-6" ng-show="topProduct">
        <!-- small box -->
        <div class="small-box bg-aqua" style="background: rgba(255, 206, 86, 1) !important;">
            <div class="inner">
                <h3>@{{ topProduct.todayTotalSale|currency:'PKR ' }}</h3>
                <p>Today's Sale</p>
            </div>
            <div class="icon">
                <i class="fa fa-shopping-cart"></i>
            </div>
            {{--<a href="#" class="small-box-footer">--}}
            {{--More info <i class="fa fa-arrow-circle-right"></i>--}}
            {{--</a>--}}
        </div>
    </div>
    <div class="col-md-4 col-sm-6" ng-show="topProduct">
        <!-- small box -->
        <div class="small-box bg-aqua" style="background: rgba(51,255,0,0.7) !important;">
            <div class="inner">
                <h3>@{{ topProduct.todayTotalProfit|currency:'PKR ' }}</h3>
                <p>Today's Profit</p>
            </div>
            <div class="icon">
                <i class="fas fa-percentage"></i>
            </div>
            {{--<a href="#" class="small-box-footer">--}}
            {{--More info <i class="fa fa-arrow-circle-right"></i>--}}
            {{--</a>--}}
        </div>
    </div>
    <div class="col-md-4 col-sm-6" ng-show="topProduct">
        <!-- small box -->
        <div class="small-box bg-aqua" style="background: rgba(51,51,255,0.6) !important;">
            <div class="inner">
                <h3>@{{ topProduct.todayExpense|currency:'PKR ' }}</h3>
                <p>Today's Expense</p>
            </div>
            <div class="icon">
                <i class="fas fa-rupee-sign"></i>
            </div>
            {{--<a href="#" class="small-box-footer">--}}
            {{--More info <i class="fa fa-arrow-circle-right"></i>--}}
            {{--</a>--}}
        </div>
    </div>
    <div class="col-md-4 col-sm-6" ng-show="topProduct">
        <!-- small box -->
        <div class="small-box bg-aqua" style="background: rgba(102,0,0,0.5) !important;">
            <div class="inner">
                <h3>@{{ topProduct.cashInHand|currency:'PKR ' }}</h3>
                <p>Cash In Hand Today</p>
            </div>
            <div class="icon">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            {{--<a href="#" class="small-box-footer">--}}
            {{--More info <i class="fa fa-arrow-circle-right"></i>--}}
            {{--</a>--}}
        </div>
    </div>
</div>
@include('dashboard.styles')