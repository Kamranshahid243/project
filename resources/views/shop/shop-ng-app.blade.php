@push('head-scripts')
<script>
(function () {
angular.module("myApp").controller('MainController', MainController);

function MainController($http, $scope, PageState, toaster) {
    $scope.shopsArray = [];
    $scope.recordsInfo = {};
    $scope.form = {};
    var state = $scope.state = PageState;
    state.params.sort = 'shop_id';
    state.loadingShops = false;

    $scope.loadShops = function () {
        state.loadingShops = true;
        $http.get("/shops", {params: state.params})
            .then(function (response) {
                $scope.shopsArray = response.data.data;
                console.log($scope.shopsArray);
                $scope.recordsInfo = response.data;
            })
            .catch(function (res) {
                toaster.pop('error', 'Error while loading Shops', res.data);
            })
            .then(function () {
                state.loadingShops = false;
            });
    };

    $scope.$watch('state.params', $scope.loadShops, true);

    $scope.bulkAssignerFields = {
        shopName: {name: 'shopName', label: 'Shop Name'},
        printerType: {name: 'printerType', label: 'Printer Type'}
    };

    $scope.csvFields = [
        {name: 'shop_id', label: 'Id'},
        {name: 'shop_name', label: 'Name'},
        {name: 'shop_address', label: 'Address'},
        {name: 'shop_type', label: 'Shop Type'},
        {name: 'printer_type', label: 'Printer Type'},
        {name: 'created_at', label: 'Created At'},
        {name: 'updated_at', label: 'Updated At'}
    ];
}
})();
</script>
@endpush