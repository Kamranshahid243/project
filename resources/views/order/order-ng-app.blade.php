@push('head-scripts')
<script>
(function () {
angular.module("myApp").controller('MainController', MainController);

function MainController($http, $scope, PageState, toaster) {


    $scope.orders = [];
    $scope.recordsInfo = {};
    $scope.form = {};
    var state = $scope.state = PageState;
    state.loadingOrders = false;

    $scope.loadOrders = function () {
        $scope.orders = [];

        state.loadingOrders = true;
        $http.get("/orders", {params: state.params})
            .then(function (response) {
                $scope.orders = response.data.data;
                $scope.recordsInfo = response.data;
            })
            .catch(function (res) {
                toaster.pop('error', 'Error while loading Orders', res.data);
            })
            .then(function () {
                state.loadingOrders = false;
            });
    };

    $scope.$watch('state.params', $scope.loadOrders, true);

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

    $scope.removeOrder = function (field) {
        if ($scope.fields.length == 1)
            return;
        var index = $scope.fields.indexOf(field);
        $scope.fields.splice(index, 1);
    }
    
    $scope.addOrder=function () {
        alert();
    }
    }
})();
</script>
@endpush