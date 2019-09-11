@push('head-scripts')
    <script>
        (function () {
            angular.module("myApp").controller('MainController', MainController);

            function MainController($http, $scope, PageState, toaster, $uibModal) {
                $scope.orders = [];
                $scope.recordsInfo = {};
                $scope.form = {};
                $scope.modalBill = [];
                $scope.customers = [];
                $scope.products = [];
                $scope.OrderProducts = [];
                var flag = $scope.flag = {saleRecord: false};
                var state = $scope.state = PageState;
                state.loadingOrders = false;
                state.loadingProducts = false;
                $scope.bill = [];

                $scope.loadOrders = function () {
                    $scope.orders = [];
                    state.loadingOrders = true;
                    $http.get("/bills", {params: state.params})
                        .then(function (res) {
                            $scope.orders = res.data.data
                        })
                        .catch(function (res) {
                            toaster.pop('error', 'Error while loading Orders', res.data);
                        })
                        .then(function () {
                            state.loadingOrders = false;
                        });
                };
                $scope.$watch('state.params', $scope.loadOrders, true);

                $scope.searchBill = function (name) {
                    state.loadingOrders = true;
                    $http({
                        url: '/orderSearch',
                        method: 'post',
                        data: {name: name}
                    }).then(function (res) {
                        $scope.orders = res.data;
                    }).catch(function (res) {
                        toaster.pop('error', 'Sorry no bill exist of this name');
                    }).then(function (res) {
                        state.loadingOrders = false;
                    });
                }

                // document.getElementById('btn').style.background = "Black";

                $scope.totalprice = function (orders) {
                    var total = 0;
                    if (orders) {
                        for (i = 0; i < orders.length; i++) {
                            var data = orders[i];
                            total += data.price
                        }
                        return total;
                    }
                }

                $scope.totalQty = function (orders) {
                    var total = 0;
                    if (orders) {
                        for (i = 0; i < orders.length; i++) {
                            var data = orders[i];
                            total += data.qty
                        }
                        return total;
                    }
                }

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


                $scope.getOrders = function () {
                    $http({
                        url: 'orders',
                        method: 'get',
                    }).then(function (res) {
                        console.log(res.data);
                    });
                }
                // $scope.getOrders();

                $scope.viewReciept = function (data) {
                    $http({
                        url: 'showReciept',
                        method: 'post',
                        data: {data: data}
                    })
                }
                $scope.recieptData = function () {
                    $http({
                        url: 'reciept',
                        method: 'get',
                    }).then(function (res) {
                        window.location.href = 'showReciept?id=' + res.data.id;
                    })
                }

                $scope.SaleOrder = function (order, customer, shop, paid) {
                    if (flag.saleRecord) return;
                    flag.saleRecord = true;
                    if (paid > $scope.totalBill()) {
                        toaster.pop("error", "Paid price is greater than total price");
                        flag.saleRecord = false;
                        return;
                    }
                    $http({
                        url: 'addOrder',
                        method: 'post',
                        data: {order: order, customer: customer, shop: shop, paid: paid}
                    }).then(function (res) {
                        console.log(res.data);
                        toaster.pop('success', 'Bill saved');
                        $scope.recieptData();
                        $scope.bill = [];
                    }).catch(function (res) {
                        toaster.pop('error', 'Field is missing');
                    }).then(function (res) {
                        flag.saleRecord = false;
                    })
                }

                $scope.searchProduct = function (product) {
                    $http({
                        url: 'searchproduct',
                        method: 'post',
                        data: {data: product}
                    }).then(function (res) {
                        $scope.products = res.data;
                    })
                }

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
                $scope.orderDetail = function (record) {
                    var modal = $uibModal.open({
                        animation: true,
                        templateUrl: 'orderDetails.html',
                        controller: function ($scope) {
                            $scope.billDetails = record;
                        },
                        size: 'md',
                    });
                }

                $scope.addCustomer = function () {
                    var modal = $uibModal.open({
                        animation: true,
                        templateUrl: 'addCustomers.html',
                        controller: function ($scope) {
                            $scope.modal = modal;
                            $scope.add = function (name, address, email, phone, type, status) {
                                $http({
                                    url: '/customers',
                                    method: 'post',
                                    data: {
                                        customer_name: name,
                                        customer_address: address,
                                        customer_email: email,
                                        customer_phone: phone,
                                        customer_type: type,
                                        status: status
                                    }
                                }).then(function (res) {
                                    modal.close(res.data);
                                    $scope.Customers();
                                    toaster.pop('success', 'Customer Added')
                                }).catch(function (res) {
                                    angular.forEach(res.data, function (value, key) {
                                        toaster.pop('error', value[0]);
                                    });
                                })
                            }
                        }
                    });
                    modal.result.then(function (res) {
                        $('#addCustomer').append('<option selected value="' + res.customer_id + '">' + res.customer_name + '</option>');
                    }, function () {

                    });
                }
            }
        })();

    </script>
@endpush