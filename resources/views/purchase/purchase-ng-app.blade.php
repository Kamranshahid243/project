@push('head-scripts')
    <script>
        (function () {
            angular.module("myApp").controller('MainController', MainController);

            function MainController($uibModal,$http, $scope, toaster, PageState) {
                $scope.purchases = [];
                $scope.recordsInfo = {};
                $scope.form = {};
                var state = $scope.state = PageState;
                state.loadingPurchases = false;
                $scope.loadPurchases = function () {
                    state.loadingPurchases = true;
                    $http.get("purchases", {params: state.params}).then(function (res) {
                        $scope.purchases = res.data.data;
                        $scope.recordsInfo = res.data;
                    }).catch(function (res) {
                        toaster.pop('error', 'Error while loading Purchases', res.data);
                    }).then(function (res) {
                        state.loadingPurchases = false;
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
                $scope.$watch('state.params', $scope.loadPurchases, true);

                $scope.bulkAssignerFields = {
                    date: {name: 'date', label: 'Date', value: 0},
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

                $scope.loadVendors = function () {
                    $http.get("get-vendors").then(function (res) {
                        $scope.vendors = res.data;
                    }).catch(function (res) {
                        toaster.pop('error', 'Error while loading Products', res.data);
                    })
                };
                $scope.loadVendors();

            // modal
                $scope.purchaseModal = function (item) {
                    var modal = $uibModal.open({
                        animation: true,
                        // ariaLabelledBy: 'modal-title',
                        // ariaDescribedBy: 'modal-body',
                        templateUrl: 'myModalContent.html',
                        controller: function($scope){
                            $scope.item=item;
                            $scope.modal=modal;
                            $scope.ok = function () {
                                $uibModal.close();
                            };
                            $scope.cancel = function () {
                                modal.dismiss();
                            };
                        },
                    });

                    modal.result.then(function () {
                        $scope.loadPurchases();
                    });



                };
            }
        })();
    </script>
@endpush