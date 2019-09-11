<div class="row" ng-show="{{session('shop')}}">
    <div class="col-md-6" ng-if="productQty.length">
        <canvas id="qtyChart"></canvas>
    </div>
    <div class="col-md-6" ng-if="productProfit.length">
        <canvas id="profitChart"></canvas>
    </div>
</div>
<br>
<div class="row" >
    <div class="col-md-8" ng-if="allSales.length">
        <canvas id="saleChart"></canvas>
    </div>
</div>