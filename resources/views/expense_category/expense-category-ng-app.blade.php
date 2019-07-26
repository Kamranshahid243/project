@push('head-scripts')
    <script>
        (function () {
            angular.module("myApp").controller('MainController', MainController);

            function MainController($http, $scope, PageState, toaster) {
                $scope.expenseCategories = [];
                $scope.recordsInfo = {};
                $scope.form = {};
                var state = $scope.state = PageState;
                state.loadingExpenseCategories = false;

                $scope.loadExpenseCategories= function () {
                    $scope.expenseCategories = [];
                    state.loadingExpenseCategories = true;
                    $http.get("/expense-category", {params: state.params})
                        .then(function (response) {
                            $scope.expenseCategories = response.data.data;
                            $scope.recordsInfo = response.data;
                        })
                        .catch(function (res) {
                            toaster.pop('error', 'Error while loading Expense Categories', res.data);
                        })
                        .then(function () {
                            state.loadingExpenseCategories = false;
                        });
                };

                $scope.$watch('state.params', $scope.loadExpenseCategories, true);

                $scope.bulkAssignerFields = {
                    cat_name: {name: 'cat_name', label: 'Category'},
                    status: {name: 'status', label: 'Status'},
                };

                $scope.csvFields = [
                    {name: 'id', label: 'Id'},
                    {name:'cat_name',  label: 'Category'},
                    {name: 'status', label: 'Status'},
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

            }
        })();
    </script>
@endpush