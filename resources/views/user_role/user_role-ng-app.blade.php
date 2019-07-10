@push('head-scripts')
<script>
(function () {
angular.module("myApp").controller('MainController', MainController);

function MainController($http, $scope, toaster, NvdNgTreeService) {
    $scope.form = {};
    $scope.roles = [];
    $scope.pages = [];
    $scope.pagesTree = new NvdNgTreeService([]);
    var state = $scope.state = {
        loading: {
            roles: false,
            pages: false,
            saveResponse: false
        },
        selectedRole: null
    };

    $scope.loadRoles = function () {
        state.loading.roles = true;
        return $http.get("/user-role").then(
                function (response) {
                    $scope.roles = response.data;
                    if ($scope.roles.length && !state.selectedRole)
                        state.selectedRole = $scope.roles[0];
                    else
                        state.selectedRole = $scope.roles.findOne(function (role) {
                            return role.id == state.selectedRole.id;
                        });
                    state.loading.roles = false;
                },
                function (response) {
                    toaster.pop('error', 'Error while loading admin roles', response.data);
                    state.loading.roles = false;
                }
        );
    };

    $scope.loadPages = function () {
        state.loading.pages = true;
        return $http.get("/page").then(
                function (response) {
                    $scope.pages = response.data;
                    $scope.makePagesTree();
                    state.loading.pages = false;
                },
                function (response) {
                    toaster.pop('error', 'Error while loading pages', response.data);
                    state.loading.pages = false;
                }
        );
    };

    $scope.makePagesTree = function () {
        var pages = $scope.pages;
        var rootNode = {
            id: -1,
            label: "All Pages",
            children: [],
            opened: true
        };

        for (var $i = 0; $i < pages.length; $i++) {
            var currentPage = pages[$i];
            var pageNode = {id: -1 * ($i + 2), label: currentPage.title, children: [], opened: false};
            for (var $j = 0; $j < currentPage.actions.length; $j++) {
                var currentAction = currentPage.actions[$j];
                var actionNode = {id: currentAction.id, label: currentAction.title};
                var actionInSelectedRole = state.selectedRole.page_actions.findOne(function (role) {
                    return role.id == actionNode.id;
                });
                if (actionInSelectedRole)
                    actionNode.checked = true;
                pageNode.children.push(actionNode)
            }
            rootNode.children.push(pageNode);
        }

        $scope.pagesTree = new NvdNgTreeService([rootNode]);
    };

    $scope.saveRole = function () {
        var checked = $scope.pagesTree.getChecked();
        var pages = checked.length ? checked[0].children : [];
        var data = {
            role: state.selectedRole.id,
            pages: pages
        };

        return $http.post('/user-role/save-actions', data).then(
                function (response) {
                    state.selectedRole.page_actions = response.data;
                    toaster.pop('success', '', 'Saved');
                    state.loading.saveResponse = false;
                },
                function (response) {
                    toaster.pop('error', 'Error while saving settings', response.data);
                    state.loading.saveResponse = false;
                }
        );
    };

    $scope.loadRoles().then($scope.loadPages);

    $scope.$watch('state.selectedRole', $scope.makePagesTree);

    $scope.csvFields = [
        {name: 'id', label: 'Id'},
        {name: 'role', label: 'Role'},
        {name: 'default_read_access', label: 'Default Read Access'},
        {name: 'default_cud_access', label: 'Default Cud Access'},
        {name: 'created_at', label: 'Created At'},
        {name: 'updated_at', label: 'Updated At'}
    ];
}
})();
</script>
@endpush