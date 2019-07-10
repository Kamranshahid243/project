@push('head-scripts')
<script>
(function () {
angular.module("myApp").controller('MainController', MainController);

function MainController($http, $scope, PageState, toaster) {
    $scope.users = [];
    $scope.recordsInfo = {};
    $scope.form = {};
    var state = $scope.state = PageState;
    state.loadingUsers = false;

    $scope.loadUsers = function () {
        $scope.users = [];
        state.loadingUsers = true;
        $http.get("/user", {params: state.params})
            .then(function (response) {
                $scope.users = response.data.data;
                $scope.recordsInfo = response.data;
            })
            .catch(function (res) {
                toaster.pop('error', 'Error while loading Users', res.data);
            })
            .then(function () {
                state.loadingUsers = false;
            });
    };

    $scope.$watch('state.params', $scope.loadUsers, true);

    $scope.bulkAssignerFields = {
        status: {name: 'status', label: 'Status'},
        user_role_id: {name: 'user_role_id', label: 'User Role'}
    };

    $scope.csvFields = [
        {name: 'id', label: 'Id'},
        {name: 'name', label: 'Name'},
        {name: 'email', label: 'Email'},
        {name: 'status', label: 'Status'},
        {name: 'user_role_id', label: 'User Role Id'},
        {name: 'created_at', label: 'Created At'},
        {name: 'updated_at', label: 'Updated At'}
    ];
}
})();
</script>
@endpush