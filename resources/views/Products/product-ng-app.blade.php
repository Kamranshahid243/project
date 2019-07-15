@push('head-scripts')
    <script>
        (function () {
            angular.module("myApp").controller('ProductController', ProductController);

            function ProductController($http, $scope, toaster, PageState) {
                $scope.form = {};
                var state = $scope.state = PageState;
                state.params.sort = 'product_id';
                state.params.sortType = 'desc';
                $scope.loadProducts = function () {
                    $http.get("showProducts", {params: state.params}).then(function (res) {
                        console.log(res.data);
                        $scope.products = res.data;
                        console.log($scope.products)
                        $scope.recordInfo = res.data.data;
                    }).catch(function (res) {
                        toaster.pop('error', 'Error while loading Products', res.data);
                    })
                };
                $scope.$watch('state.params', $scope.loadProducts, true);
            }
        })();
    </script>
@endpush