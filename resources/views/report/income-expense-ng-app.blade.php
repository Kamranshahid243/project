@push('head-scripts')
    <script>
        (function () {
            angular.module("myApp").controller('MainController', MainController);

            function MainController($http, $scope, PageState, toaster) {
                var state = $scope.state = {};
                var states=$scope.states={
                    loadingReport:false
                }
                $scope.start = moment().startOf('month');
                $scope.end = moment().endOf('month');
                $scope.updateDate = function () {
                if($scope.dateSelector=='thisMonth'){
                    $scope.start = moment().startOf('month');
                    $scope.end = moment().endOf('month');
                }
                if ($scope.dateSelector=='lastMonth'){
                    $scope.start= moment().add(-1,'month').startOf('month');
                    $scope.end = moment().add(-1, 'month').endOf('month');
                }
                if ($scope.dateSelector == 'currentYear') {
                    $scope.start = moment().startOf('year').format();
                    $scope.end = moment().endOf('year').format();
                }
                console.log($scope.dateSelector, moment().startOf('month'));
            }
            $scope.showReport=function (startDate,endDate) {
                state.loadingReport=true;
                    $http({
                    url:'show-report',
                    method:'post',
                    data:{startDate:startDate,endDate:endDate}
                }).then(function (response) {
                    console.log(response.data);
                    $scope.reports=response.data;
                }).catch(function (res) {

                }).then(function (res) {
                    state.loadingReport=false;
                });
            }

                // $scope.getShops = function () {
                //     $http({
                //         url: 'get-shops',
                //         mehtod: 'get'
                //     }).then(function (response) {
                //         $scope.allShops = response.data;
                //     });
                // }
                // $scope.getShops();
            }

        })();
    </script>
@endpush

