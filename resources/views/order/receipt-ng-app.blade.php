@push('head-scripts')
    <script>
        (function () {
            angular.module("myApp").controller('MainController', MainController);

            function MainController($http, $scope, PageState, toaster, $uibModal) {
                $scope.recieptData = function () {
                    $http({
                        url: 'reciept',
                        method: 'get',
                    }).then(function (res) {
                        console.log(res.data);
                        $scope.data = res.data;
                    })

                }
                $scope.recieptData();
            }
        })();

    </script>
@endpush