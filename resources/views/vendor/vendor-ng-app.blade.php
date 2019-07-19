@push('head-scripts')
    <script>
        (function () {
            angular.module("myApp").controller('VendorController', VendorController);

            function VendorController($http, $scope, toaster, PageState) {
                $scope.Vendors = [];
                $scope.recordsInfo = {};
                $scope.form = {};
                var state = $scope.state = PageState;
                state.loadingVendors = false;
                state.params.sort = 'shop_id';
                $scope.loadVendors = function () {
                    state.loadingVendors = true;
                    $http.get("vendor", {params: state.params}).then(function (res) {
                        $scope.vendors = res.data.data;
                        $scope.recordsInfo = res.data;
                    }).catch(function (res) {
                        toaster.pop('error', 'Error while loading Vendors', res.data);
                    }).then(function (res) {
                        state.loadingVendors = false;
                    });
                };

                $scope.$watch('state.params', $scope.loadVendors, true);

                $scope.bulkAssignerFields = {
                    Vendorname: {name: 'vendor_name', label: 'Name', value: ''},
                    vendorStatus: {name: 'vendor_status', label: 'product Status', value: ''}
                };

                $scope.csvFields = [
                    {name: 'shop_id', label: 'Shop Id'},
                    {name: 'vendor_name', label: 'Vendor Name'},
                    {name: 'vendor_address', label: 'Vendor Address'},
                    {name: 'vendor_phone', label: 'Vendor Phone'},
                    {name: 'vendor_email', label: 'Vendor Email'},
                    {name: 'vendor_status', label: 'Vendor Status'},
                    {name: 'created_at', label: 'Created at'},
                    {name: 'updated_at', label: 'Updated at'},
                ];
            }
        })();
    </script>
@endpush