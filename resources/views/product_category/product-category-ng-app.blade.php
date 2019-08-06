@push('head-scripts')
    <script>
        (function () {
            angular.module("myApp").controller('MainController', MainController);

            function MainController($http, $scope, PageState, toaster) {
                $scope.productCategories = [];
                $scope.recordsInfo = {};
                $scope.form = {};
                var state = $scope.state = PageState;
                state.loadingCategories = false;

                $scope.loadproductCategories = function () {
                    $scope.productCategories = [];
                    state.loadingCategories = true;
                    $http.get("/product-category", {params: state.params})
                        .then(function (res) {
                            $scope.productCategories = res.data;
                        })
                        .catch(function (res) {
                            toaster.pop('error', 'Error while loading Vendor Categories', res.data);
                        })
                        .then(function () {
                            state.loadingCategories = false;
                        });
                };

                $scope.$watch('state.params', $scope.loadproductCategories, true);

                $scope.changeStatus = function (category) {
                    state.loadingCategories = true;

                    if (category.status == 0)
                        category.status == 1;
                    else
                        category.status == 0;
                    $http({
                        'method': 'post',
                        'url': 'changestatus',
                        'data': {id: category.id}
                    }).then(function (res) {

                    }).catch(function (res) {

                    }).then(function () {
                        state.loadingCategories = false;
                    })
                }

            }
        })();
    </script>
@endpush