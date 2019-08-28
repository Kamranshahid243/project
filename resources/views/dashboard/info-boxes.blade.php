<div class="row" ng-controller="MainController">
    <div class="col-md-4 col-sm-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">

                <h3>@{{ topProduct.maxProduct.product.product_name }}</h3>
                <p>Top Seller Quantity(@{{ topProduct.maxQuantity + " Pcs)" }}</p>
            </div>
            <div class="icon">
                <i class="fab fa-product-hunt"></i>
            </div>
            <a href="#" class="small-box-footer">
                More info <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <!-- small box -->
        <div class="small-box bg-aqua" style="background: rgba(102,204,102,1) !important;">
            <div class="inner">
                <h3>150</h3>
                <p>New Orders</p>
            </div>
            <div class="icon">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="#" class="small-box-footer">
                More info <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <!-- small box -->
        <div class="small-box bg-aqua" style="background: rgba(255, 206, 86, 1) !important;">
            <div class="inner">
                <h3>150</h3>
                <p>New Orders</p>
            </div>
            <div class="icon">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="#" class="small-box-footer">
                More info <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <!-- small box -->
        <div class="small-box bg-aqua" style="background: rgba(51,255,0,0.7) !important;">
            <div class="inner">
                <h3>150</h3>
                <p>New Orders</p>
            </div>
            <div class="icon">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="#" class="small-box-footer">
                More info <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <!-- small box -->
        <div class="small-box bg-aqua" style="background: rgba(51,51,255,0.6) !important;">
            <div class="inner">
                <h3>150</h3>
                <p>New Orders</p>
            </div>
            <div class="icon">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="#" class="small-box-footer">
                More info <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>
@include('dashboard.dashboard-ng-app')