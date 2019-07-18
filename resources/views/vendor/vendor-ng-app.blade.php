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

                // $scope.csvFields = [
                //     {name: 'product_id', label: 'Id'},
                //     {name: 'shop_id', label: 'Shop Id'},
                //     {name: 'product_name', label: 'product Name'},
                //     {name: 'product_code', label: 'Product Code'},
                //     {name: 'printer_type', label: 'Printer Type'},
                //     {name: 'product_description', label: 'Product Description'},
                //     {name: 'available_quantity', label: 'Available Quantity'},
                //     {name: 'unit_price', label: 'Unit Price'},
                //     {name: 'created_at', label: 'Created at'},
                //     {name: 'updated_at', label: 'Updated at'},
                // ];
            }
        })();
    </script>
@endpush