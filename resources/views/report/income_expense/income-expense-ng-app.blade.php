@push('head-scripts')
    <script>
        (function () {
            angular.module("myApp").controller('MainController', MainController);

            function MainController($http, $scope, PageState, toaster) {
                var state = $scope.state = {};
                var states = $scope.states = {
                    loadingReport: false
                }
                $scope.dateSelector = 'thisMonth';
                $scope.start = moment().startOf('month');
                $scope.end = moment().endOf('month');
                $scope.lastmonth = moment().add(-1, 'month').startOf('month');
                $scope.updateDate = function () {
                    if ($scope.dateSelector == 'thisMonth') {
                        $scope.start = moment().startOf('month');
                        $scope.end = moment().endOf('month');
                    }
                    if ($scope.dateSelector == 'lastMonth') {
                        $scope.start = moment().subtract(1, 'month').startOf('month');
                        $scope.end = moment().subtract(1, 'month').endOf('month');
                    }
                    if ($scope.dateSelector == 'currentYear') {
                        $scope.start = moment().startOf('year').format();
                        $scope.end = moment().endOf('year').format();
                    }
                }
                $scope.showReport = function (startDate, endDate) {
                    state.loadingReport = true;
                    $http({
                        url: 'show-report',
                        method: 'post',
                        data: {startDate: startDate, endDate: endDate}
                    }).then(function (response) {
                        $scope.reports = response.data;
                    }).catch(function (res) {

                    }).then(function (res) {
                        state.loadingReport = false;
                    });
                }

                $scope.loadIncome = function () {
                    $http.get('income')
                        .then(function (res) {
                            $scope.incomes = res.data;
                        });
                }
                $scope.loadIncome();

                $scope.LoadExpense = function () {
                    $http.get('expenses')
                        .then(function (res) {
                        })
                }

            }

        })();
    </script>
@endpush

