@push('head-scripts')
<script>
    (function () {
        'use strict';
        angular.module('myApp').controller('testController',mainController);
        function mainController($scope,$http) {
            $scope.showShops=function(){
                $http.get('test').then(function (res) {
                    $scope.dukaan=res.data;
                    console.log($scope.dukaan);
                });
            }
            $scope.showShops();
        }
    })()
</script>
    @endpush