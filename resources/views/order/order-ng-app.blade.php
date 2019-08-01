@push('head-scripts')
    <script>
        (function () {
                angular.module("myApp").controller('MainController', MainController);

                function MainController($http, $scope, PageState, toaster) {
                    $scope.orders = [];
                    $scope.recordsInfo = {};
                    $scope.form = {};
                    $scope.customers = [];
                    $scope.products = [];
                    $scope.OrderProducts = [];
                    var state = $scope.state = PageState;
                    state.params.sort = 'order_id';
                    state.loadingOrders = false;
                    state.loadingProducts = false;

                    $scope.loadProducts = function () {
                        state.loadingProducts = true;
                        $http.get("editProducts")
                            .then(function (res) {
                                $scope.products = res.data;
                            })
                            .catch(function (res) {
                                toaster.pop('error', 'Error while loading Orders', res.data);
                            })
                            .then(function () {
                                state.loadingProducts = false;
                            });
                    };
                    $scope.loadProducts();

                    $scope.Customers = function () {
                        $http.get("customers")
                            .then(function (res) {
                                $scope.customers = res.data;
                            }).catch(function (res) {
                            toaster.pop('error', 'Error while loading Customers', res.data);
                        })
                    };
                    $scope.Customers();

                    $scope.Shops = function () {
                        $http.get('shops')
                            .then(function (res) {
                                $scope.shops = res.data;
                            }).catch(function (res) {
                            toaster.pop('error', 'Error while loading Shops', res.data)
                        })
                    };
                    $scope.Shops();

                    $scope.SaleOrder = function (order, customer, shop) {
                        $http({
                            url: 'addOrder',
                            method: 'post',
                            data: {order: order, customer_id: customer, shop: shop}
                        }).then(function (res) {
                            toaster.pop('success', 'Saved Bill')
                        }).catch(function (res) {
                            toaster.pop('error', 'Field is missing');
                        })
                    }

                    $scope.loadOrders = function () {
                        $scope.orders = [];

                        state.loadingOrders = true;
                        $http.get("/orders", {params: state.params})
                            .then(function (response) {
                                $scope.orders = response.data.data;
                                $scope.recordsInfo = response.data;
                            })
                            .catch(function (res) {
                                toaster.pop('error', 'Error while loading Orders', res.data);
                            })
                            .then(function () {
                                state.loadingOrders = false;
                            });
                    };

                    $scope.$watch('state.params', $scope.loadOrders, true);

                    $scope.bill = [];
                    $scope.addOrder = function (product) {
                        if (product.available_quantity >= 0) {
                            product.available_quantity = product.available_quantity - 1;
                        }

                        if (product.available_quantity < 0) {
                            product.available_quantity = 0;
                            return;
                        }
                        // if already exist
                        var existing = $scope.bill.findOne(function (item) {
                            return item.product_id == product.product_id;
                        });
                        if (existing) {
                            if (product.available_quantity >= 0) {
                                return existing.available_quantity++;
                            }
                        }

                        // if record does not exist
                        var duplicateRecord = angular.extend({}, product);
                        duplicateRecord.available_quantity = 1;
                        $scope.bill.push(duplicateRecord);
                        $scope.OrderProducts.push(product);
                    }
                    $scope.totalBill = function () {
                        var total = 0;
                        for (i = 0; i < $scope.bill.length; i++) {
                            var item = $scope.bill[i];
                            total += item.available_quantity * item.unit_price;
                        }
                        return total;
                    }

                    $scope.OrderProducts = [];
                    $scope.addAction = function (order) {
                        var existing = $scope.OrderProducts.findOne(function (item) {
                            return item.product_id == order.product_id;
                        });
                        if (existing.available_quantity != 0) {
                            order.available_quantity = order.available_quantity + 1;
                        }
                        if (existing) {
                            if (existing.available_quantity > 0) {
                                existing.available_quantity--;
                                return;
                            }
                        }
                    };

                    $scope.lessAction = function (order) {
                        var existing = $scope.OrderProducts.findOne(function (item) {
                            return item.product_id == order.product_id;
                        });
                        if (order.available_quantity != 0) {
                            order.available_quantity = order.available_quantity - 1;
                        }
                        if (existing) {
                            if (order.available_quantity != 0) {
                                existing.available_quantity++;
                                return;
                            }
                        }
                        if (order.available_quantity <= 0) {
                            order.available_quantity = 1;
                        }
                        return order;
                    }
                    $scope.clearitems = function () {
                        if ($scope.bill) {
                            $scope.bill = [];
                            $scope.OrderProducts = [];
                        }
                        $scope.loadProducts();
                    }

                    $scope.deleteItem = function (order) {
                        var existed = $scope.bill.findOne(function (item) {
                            return item.product_id == order.product_id;
                        })
                        $scope.bill.remove(existed);
                        $scope.loadProducts();
                    }
                }
            }

        )();

    </script>
@endpush