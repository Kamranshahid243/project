@push('head-scripts')
<script>
(function () {
angular.module("myApp").controller('MainController', MainController);

function MainController($http, $scope, toaster) {
    $scope.user = {};
    $scope.passwordForm = {};
    var state = $scope.state = {
        loadingUser: false
    };

    $scope.loadUser = function () {
        $scope.user = {};
        state.loadingUser = true;
        $http.get("/user/profile", {params: state.params})
            .then(function (response) {
                $scope.user = response.data;
            })
            .catch(function (res) {
                toaster.pop('error', 'Error while loading Users', res.data);
            })
            .then(function () {
                state.loadingUser = false;
            });
    };

    $scope.loadUser();

}
})();
</script>
@endpush