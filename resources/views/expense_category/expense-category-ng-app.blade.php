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
                    $http.get("/expense-category")
                        .then(function (response) {
                            $scope.expenseCategories = response.data;
                            // $scope.recordsInfo = response.data;
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
                $scope.changeStatus = function (category) {
                    state.loadingCategories = true;

                    if (category.status == 'Active')
                        category.status == 'Inactive';
                    else
                        category.status == 'Active';
                    $http({
                        method: 'post',
                        url: 'category-expense-status',
                        data: {id: category.id}
                    }).then(function (res) {

                    }).catch(function (res) {

                    }).then(function () {
                        $scope.loadExpenseCategories()
                    })
                }
            }
        })();
    </script>
@endpush