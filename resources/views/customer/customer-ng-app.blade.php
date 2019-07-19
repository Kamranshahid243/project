@push('head-scripts')
    <script>
        (function () {
            angular.module("myApp").controller('MainController', MainController);

            function MainController($http, $scope, PageState, toaster) {
                $scope.customers = [];
                $scope.recordsInfo = {};
                $scope.form = {};
                var state = $scope.state = PageState;
                state.params.sort = 'customer_id';
                state.loadingCustomers = false;

                $scope.loadCustomers = function () {
                    $scope.customers = [];
                    state.loadingCustomers = true;
                    $http.get("/customers", {params: state.params})
                        .then(function (response) {
                            $scope.customers = response.data.data;
                            $scope.recordsInfo = response.data;
                        })
                        .catch(function (res) {
                            toaster.pop('error', 'Error while loading Customers', res.data);
                        })
                        .then(function () {
                            state.loadingCustomers = false;
                        });
                };

                $scope.$watch('state.params', $scope.loadCustomers, true);

                $scope.bulkAssignerFields = {
                    shop_id: {name: 'shop_id', label: 'Shop'},
                    customer_type: {name: 'customer_type', label: 'Customer Type'}
                };

                $scope.csvFields = [
                    {name: 'customer_id', label: 'Id'},
                    {name:'shop_id',  label: 'Shop'},
                    {name: 'customer_name', label: 'Name'},
                    {name: 'customer_email', label: 'Email'},
                    {name: 'customer_address', label: 'Address'},
                    {name: 'customer_phone', label: 'Customer Phone'},
                    {name: 'customer_type', label: 'Customer Type'},
                    {name: 'created_at', label: 'Created At'},
                    {name: 'updated_at', label: 'Updated At'}
                ];

                $scope.getShops = function () {
                    $http({
                        url: 'get-shops',
                        mehtod: 'get'
                    }).then(function (response) {
                        $scope.allShops = response.data;
                    });
                }
                $scope.getShops();
                $scope.getProducts = function () {
                    $http({
                        url: 'get-products',
                        mehtod: 'get'
                    }).then(function (response) {
                        console.log(response.data);
                        $scope.allProducts = response.data;
                    });
                }
                $scope.getProducts();

            }
        })();
    </script>
@endpush