@push('head-scripts')
    <script>
        (function () {
            angular.module("myApp").controller('VendorReportController', VendorReportController);

            function VendorReportController($http, $window, $scope, toaster, PageState) {
                $scope.Vendors = [];
                $scope.recordsInfo = {};
                $scope.form = {};
                var state = $scope.state = PageState;
                state.loadingVendors = false;
                state.params.sort = 'shop_id';
                $scope.loadVendors = function () {
                    state.loadingVendors = true;
                    $http.get("vendor-report", {params: state.params}).then(function (res) {
                        $scope.vendors = res.data.data;
                        $scope.recordsInfo = res.data;
                    }).catch(function (res) {
                        toaster.pop('error', 'Error while loading Vendors', res.data);
                    }).then(function (res) {
                        state.loadingVendors = false;
                    });
                };

                $scope.loadVendorCategories = function () {
                    $http.get('get-vendor-categories').then(function (res) {
                        $scope.categories = res.data;
                    });
                }
                $scope.loadVendorCategories();
                $scope.$watch('state.params', $scope.loadVendors, true);
            }
        })();
    </script>
@endpush