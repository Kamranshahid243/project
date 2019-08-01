@push('head-scripts')
    <script>
        (function () {
            angular.module("myApp").controller('MainController', MainController);

            function MainController($http, $scope, PageState, toaster) {
                $scope.expenses = [];
                $scope.recordsInfo = {};
                $scope.form = {};
                var state = $scope.state = PageState;
                state.loadingExpenses = false;
                state.loadingReport=false;

                $scope.loadExpenses= function () {
                    $scope.expenses = [];
                    state.loadingExpenses = true;
                    $http.get("/expenses", {params: state.params})
                        .then(function (response) {
                            $scope.expenses = response.data.data;
                            $scope.recordsInfo = response.data;
                        })
                        .catch(function (res) {
                            toaster.pop('error', 'Error while loading Expenses', res.data);
                        })
                        .then(function () {
                            state.loadingExpenses = false;
                        });
                };

                $scope.$watch('state.params', $scope.loadExpenses, true);

                $scope.bulkAssignerFields = {
                    shop_id: {name: 'shop_id', label: 'Shop'},
                    rent: {name: 'rent', label: 'Rent'},
                    salaries: {name: 'salaries', label: 'Salaries'},
                    refreshment: {name: 'refreshment', label: 'Refreshment'},
                    drawing: {name: 'drawing', label: 'Drawing'},
                    loss: {name: 'loss', label: 'Loss'},
                    bills: {name: 'bills', label: 'Bills'},
                    others: {name: 'others', label: 'Others'}
                };

                $scope.csvFields = [
                    {name: 'expense_id', label: 'Id'},
                    {name:'shop_id',  label: 'Shop'},
                    {name: 'rent', label: 'Rent'},
                    {name: 'salaries', label: 'Salaries'},
                    {name: 'refreshment', label: 'Refreshment'},
                    {name: 'drawing', label: 'Drawing'},
                    {name: 'loss', label: 'Loss'},
                    {name: 'bills', label: 'Bills'},
                    {name: 'others', label: 'Others'},
                    {name: 'total', label: 'Total'},
                    {name: 'created_at', label: 'Month'}
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


                $scope.getExpenseCategories = function () {
                    $http({
                        url: 'get-categories',
                        mehtod: 'get'
                    }).then(function (response) {
                        $scope.allCategories = response.data;
                    });
                }
                $scope.getExpenseCategories();

            }
        })();
    </script>
@endpush