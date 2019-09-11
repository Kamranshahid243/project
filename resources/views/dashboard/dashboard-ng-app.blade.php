@push('head-scripts')
<script>(function () {
    angular.module('myApp').requires.push('nvdDashboard');
    angular.module("myApp").controller('MainController', MainController);

    function MainController($scope,$http, nvdDashboardService) {
        $scope.loadingData = false;
        $scope.service = nvdDashboardService;
        $scope.dashboardConfig = {
            tabs: [
                {
                    title: 'Dashboard',
                    widgets: []
                }
            ],
            syncGetUrl: '/nvd-dashboard/load-config',
            syncPostUrl: '/nvd-dashboard/save-config',
            gridsterOpts: {
                columns: 20,
                margins: [5, 5],
                defaultSizeX: 6,
                defaultSizeY: 6,
                outerMargin: true,
                pushing: true,
                floating: true,
                draggable: {
                    enabled: true,
                    handle: '.drag-handle'
                },
                resizable: {
                    enabled: true,
                    handles: ['n', 'e', 's', 'w', 'se', 'sw', 'ne', 'nw']
                }
            }
        };
        $scope.saleChart=function () {
            $http.get('sale-chart').then(function (response) {
                $scope.allSales = response.data;
            var ctx = document.getElementById('saleChart');
            var year = new Date();
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: "Annual Sale (" + year.getFullYear() + ")",
                        data:$scope.allSales,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',

                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                steps: 10,
                                stepValue: 10000,
                                max: 1000000,
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        });
        }
        $scope.saleChart();
        $scope.qtyChart = function () {
            var allQtySales = $scope.allQtySales = [];
            $http.get('qty-chart').then(function (response) {
                allQtySales = response.data;

                    $scope.productsLabel=[];
                    $scope.productQty=[];
                angular.forEach(allQtySales,function (value,key) {
                    $scope.productsLabel.push([value.product_name]);
                    $scope.productQty.push(value.tqty);
                })

                // angular.forEach(allQtySales, function (allQtySale, allQtySales) {

                // });

                var ctx = document.getElementById('qtyChart');
                var year = new Date();
                var qtyChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: $scope.productsLabel,
                        datasets: [{
                            label: "Quantity Sale (" + moment().format('MMMM YYYY') + ")",
                            data: $scope.productQty,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255,255,102,0.2)',
                                'rgba(102,204,102,0.2)',
                                'rgba(51,255,0,0.2)',
                                'rgba(102,102,255,0.2)',
                                'rgba(153,102,153,0.2)',
                                'rgba(153,102,0,0.2)',
                                'rgba(102,102,204,0.2)',
                                'rgba(255,255,153,0.2)',
                                'rgba(51,51,255,0.2)'
                            ],

                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(255,255,102,1)',
                                'rgba(102,204,102,1)',
                                'rgba(51,255,0,1)',
                                'rgba(102,102,255,1)',
                                'rgba(153,102,153,1)',
                                'rgba(153,102,0,1)',
                                'rgba(102,102,204,1)',
                                'rgba(255,255,153,1)',
                                'rgba(51,51,255,1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    steps: 10,
                                    stepValue: 5,
                                    max: 500,
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            });
        }
        $scope.qtyChart();
        $scope.profitChart = function () {
            var allProfitSales = $scope.allProfitSales = [];
            $http.get('profit-chart').then(function (response) {
                allProfitSales = response.data;
                $scope.productsLabel = [];
                $scope.productProfit = [];
                angular.forEach(allProfitSales, function (value, key) {
                    $scope.productsLabel.push([value.product_name]);
                    $scope.productProfit.push(value.tprice);

                })

                var ctx = document.getElementById('profitChart');
                var year = new Date();
                var profitChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: $scope.productsLabel,
                        datasets: [{
                            label: "Product Profit (" + moment().format('MMMM YYYY') + ")",
                            data: $scope.productProfit,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255,255,102,0.2)',
                                'rgba(102,204,102,0.2)',
                                'rgba(51,255,0,0.2)',
                                'rgba(102,102,255,0.2)',
                                'rgba(153,102,153,0.2)',
                                'rgba(153,102,0,0.2)',
                                'rgba(102,102,204,0.2)',
                                'rgba(255,255,153,0.2)',
                                'rgba(51,51,255,0.2)'
                            ],

                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(255,255,102,1)',
                                'rgba(102,204,102,1)',
                                'rgba(51,255,0,1)',
                                'rgba(102,102,255,1)',
                                'rgba(153,102,153,1)',
                                'rgba(153,102,0,1)',
                                'rgba(102,102,204,1)',
                                'rgba(255,255,153,1)',
                                'rgba(51,51,255,1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    steps: 10,
                                    stepValue: 10000,
                                    max: 300000,
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            });
        }
        $scope.profitChart();
        $scope.topSeller=function () {
            $scope.loadingData = true;
            $http.get('top-seller').then(function (response) {
                console.log(response.data);
                $scope.topProduct=response.data;
            }).catch(function (res) {
                toaster.pop('error', 'Error while loading Dashboard', res.data);
            }).then(function (res) {
                $scope.loadingData = false;
            });
        }
        $scope.topSeller();
    }
})();</script>
<link rel="stylesheet" href="/vendors/angular-gridster/angular-gridster.min.css">
<script src="/vendors/angular-gridster/angular-gridster.min.js"></script>
<script src="/vendors/angular-custom/nvd-dashboard/nvd-dashboard-directive.js"></script>
@endpush