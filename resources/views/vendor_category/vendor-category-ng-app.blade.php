@push('head-scripts')
    <script>
        (function () {
            angular.module("myApp").controller('MainController', MainController);

            function MainController($http, $scope, PageState, toaster) {
                $scope.vendorCategories = [];
                $scope.recordsInfo = {};
                $scope.form = {};
                var state = $scope.state = PageState;
                state.loadingVendorCategories = false;

                $scope.loadVendorCategories= function () {
                    $scope.vendorCategories = [];
                    state.loadingVendorCategories = true;
                    $http.get("/vendor-category", {params: state.params})
                        .then(function (response) {
                            $scope.vendorCategories = response.data.data;
                            $scope.recordsInfo = response.data;
                        })
                        .catch(function (res) {
                            toaster.pop('error', 'Error while loading Vendor Categories', res.data);
                        })
                        .then(function () {
                            state.loadingVendorCategories = false;
                        });
                };
                $scope.vendorCatStatus=function(id){
                    $http({
                        method:'get',
                        url:'vendor-category-status',
                        params:{id:id}
                    }).catch(function (res) {
                        toaster.pop('error','Error while Updating Status',res.data);
                    }).then(function () {
                        $scope.loadVendorCategories();
                    });
                }

                $scope.$watch('state.params', $scope.loadVendorCategories, true);

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