@push('head-scripts')
    <script>
        (function () {
            angular.module("myApp").controller('ProductController', ProductController);

            function ProductController($http, $scope, toaster, PageState) {
                $scope.products = [];
                $scope.recordsInfo = {};
                $scope.form = {};
                var state = $scope.state = PageState;
                state.loadingProducts = false;
                state.params.sort = 'product_id';
                $scope.loadProducts = function () {
                    state.loadingProducts = true;
                    $http.get("showProducts", {params: state.params}).then(function (res) {
                        $scope.products = res.data.data;
                        console.log($scope.products);
                        $scope.recordsInfo = res.data;
                    }).catch(function (res) {
                        toaster.pop('error', 'Error while loading Products', res.data);
                    }).then(function (res) {
                        state.loadingProducts = false;
                    });
                };

                $scope.loadShops = function () {
                    $http.get("shops").then(function (res) {
                        $scope.shops = res.data;
                    }).catch(function (res) {
                        toaster.pop('error', 'Error while loading Products', res.data);
                    })
                };
                $scope.loadShops();
                $scope.$watch('state.params', $scope.loadProducts, true);

                $scope.bulkAssignerFields = {
                    AvailableQuantity: {name: 'available_quantity', label: 'Quantity', value: 0},
                    UnitPrice: {name: 'unit_price', label: 'Unit Price', value: 0},
                    productStatus: {name: 'product_status', label: 'product Status', value: 0}
                };
                $scope.csvFields = [
                    {name: 'product_id', label: 'Id'},
                    {name: 'shop_id', label: 'Shop Id'},
                    {name: 'product_name', label: 'product Name'},
                    {name: 'product_code', label: 'Product Code'},
                    {name: 'printer_type', label: 'Printer Type'},
                    {name: 'product_description', label: 'Product Description'},
                    {name: 'available_quantity', label: 'Available Quantity'},
                    {name: 'unit_price', label: 'Unit Price'},
                    {name: 'created_at', label: 'Created at'},
                    {name: 'updated_at', label: 'Updated at'},
                ];
            }
        })();
    </script>
@endpush