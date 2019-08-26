@push('head-scripts')
    <script>
        (function () {
            angular.module("myApp").controller('MainController', MainController);

            function MainController($http, $scope, PageState, toaster) {
                $scope.productsReports = [];
                $scope.recordsInfo = {};
                $scope.form = {};
                $scope.products = [];
                var state = $scope.state = PageState;
                state.params.sort = 'product_id';
                state.params.sortType = 'desc';

                state.loadingProductsReport = false;
                $scope.dateSelector='thisMonth';
                $scope.start = moment().startOf('month').add(1, 'day').format('YYYY-MM-DD');
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
                $scope.showProductsReport = function () {
                    state.params.start_date = $scope.start;
                    state.params.end_date = $scope.end;
                    state.loadingProductsReport = true;
                    var date ={
                        start_date : $scope.start,
                        end_date : $scope.end
                    }
                    $http.get('orders', {params:date}
                    ).then(function (response) {
                        $scope.orders=response.data;
                        $scope.loadProducts().then(function (res) {
                            $scope.reportProducts=$scope.products;
                            state.loadingProductsReport = false;
                        })
                    }).catch(function (res) {
                        toaster.pop('error', 'Error while loading Products Summary', res.data);
                    });

                }

                $scope.loadProducts=function(){
                    return $http.get("showProducts", {params: state.params}).then(function (res) {
                        $scope.products = res.data.data;
                        $scope.recordsInfo = res.data.data;
                        angular.forEach($scope.products, function (product, productKey) {
                            product['totalQty'] = 0;
                            product['totalPrice'] = 0;
                        });
                        angular.forEach($scope.products, function (product, productKey) {
                            angular.forEach($scope.orders, function (order, orderKey) {
                                if (order.product_id === product.product_id) {
                                    product['totalQty'] += order.qty;
                                    product['totalPrice'] += order.price;
                                }
                            })
                        });
                    });
                }
            $scope.optionProducts=function(){
                     $http.get("showProducts").then(function (res) {
                       $scope.productOptions = res.data;

                    });
                }

                $scope.$watch('state.params', $scope.showProductsReport, true);

            }

        })();
    </script>
@endpush

