@push('head-scripts')
    <script>
        (function () {
            angular.module("myApp").controller('VendorProfileController', VendorProfileController);

            function VendorProfileController($http, $window, $scope, toaster, PageState) {
                $scope.vendorId = '{{$id}}';
                $scope.recordsInfo = {};
                $scope.form = {};
                var state = $scope.state = PageState;
                state.loadingVendorsReport = false;
                state.params.sort = 'vendor_id';
                state.params.id=$scope.vendorId;
                state.params.startDate
                $scope.dateSelector = 'thisMonth';
                $scope.start = moment().startOf('month').format('YYYY-MM-DD');
                $scope.end = moment().endOf('month').format('YYYY-MM-DD');
                $scope.lastmonth = moment().add(-1, 'month').startOf('month');
                $scope.updateDate = function () {
                    if ($scope.dateSelector == 'thisMonth') {
                        $scope.start = moment().startOf('month').format('YYYY-MM-DD');
                        $scope.end = moment().endOf('month').format('YYYY-MM-DD');
                    }
                    if ($scope.dateSelector == 'lastMonth') {
                        $scope.start = moment().subtract(1, 'month').startOf('month').format('YYYY-MM-DD');
                        $scope.end = moment().subtract(1, 'month').endOf('month').format('YYYY-MM-DD');
                    }
                    if ($scope.dateSelector == 'currentYear') {
                        $scope.start = moment().startOf('year').format('YYYY-MM-DD');
                        $scope.end = moment().endOf('year').format('YYYY-MM-DD');
                    }
                }
                $scope.VendorStockReport = function () {
                    state.loadingVendorsReport = true;
                    state.params.startDate =$scope.start;
                    state.params.endDate= $scope.end;
                    $http.get('detailed-report', {params: state.params}).then(function (res) {
                        // console.log(res.data);
                        $scope.vendorsReport = res.data.data;
                        $scope.recordsInfo = res.data;
                    }).catch(function (res) {
                        toaster.pop('error', 'Error while loading Vendors Report', res.data);
                    }).then(function (res) {
                        state.loadingVendorsReport = false;
                    });
                };
                $scope.vendorProfile=function(id){
                    $http({
                        method:'get',
                        url:'vendor-profile',
                        params:{id:id}
                    }).then(function(res){
                        // console.log(res.data);
                        $scope.profile=res.data;
                    });
                }
                $scope.vendorProfile($scope.vendorId);

                $scope.$watch('state.params', $scope.VendorStockReport, true);
            }
        })();
    </script>
@endpush