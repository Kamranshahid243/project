@push('head-scripts')
<script>(function () {
    angular.module('myApp').requires.push('nvdDashboard');
    angular.module("myApp").controller('MainController', MainController);

    function MainController($scope) {
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
    }
})();</script>
<link rel="stylesheet" href="/vendors/angular-gridster/angular-gridster.min.css">
<script src="/vendors/angular-gridster/angular-gridster.min.js"></script>
<script src="/vendors/angular-custom/nvd-dashboard/nvd-dashboard-directive.js"></script>
@endpush