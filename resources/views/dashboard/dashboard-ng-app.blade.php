@push('head-scripts')
<script>(function () {
    angular.module('myApp').requires.push('nvdDashboard');
    angular.module("myApp").controller('MainController', MainController);

    function MainController($scope,$http) {
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
            var allSales = $scope.allSales = [];
            $http.get('sale-chart').then(function (response) {
                allSales = response.data;
            var ctx = document.getElementById('myChart');
            var year = new Date();
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: "Annual Sale (" + year.getFullYear() + ")",
                        data:allSales,
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
    }
})();</script>
<link rel="stylesheet" href="/vendors/angular-gridster/angular-gridster.min.css">
<script src="/vendors/angular-gridster/angular-gridster.min.js"></script>
<script src="/vendors/angular-custom/nvd-dashboard/nvd-dashboard-directive.js"></script>
@endpush