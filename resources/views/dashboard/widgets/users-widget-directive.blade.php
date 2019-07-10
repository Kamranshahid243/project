<script>(function () {
    'use strict';
    angular.module('myApp').directive('usersWidget', function () {
        return {
            controller: DirectiveController,
            scope: {widget: '='},
            templateUrl: "users-widget-directive-template.html"
        };
    });

    function DirectiveController($http, $scope, toaster, $interval, socketIo) {
        $scope.admins = [];
        $scope.loadingRecords = false;
        $scope.widget.footerTemplateUrl = 'users-footer-template.html';
        $scope.widget.reloadAction = $scope.loadUsers = function () {
            $scope.loadingRecords = true;
            $http.get("/online-users/load").then(function (response) {
                $scope.admins = response.data;
            }).catch(function (response) {
                toaster.pop('error', 'Error while loading admins', response.data);
            }).then(function () {
                $scope.loadingRecords = false;
            });
        };
        $scope.loadUsers();

        socketIo.init('{{env('SOCKET_IO_SERVER')}}');
        socketIo.bind('online-user-updated', function (data) {
            var user = $scope.admins.findOne(function (u) { return u.userId == data.userId; });
            if (!user) {
                $scope.admins.push(data);
                return;
            }
            for (var prop in data) {
                user[prop] = data[prop];
            }
        });
        socketIo.bind('online-user-removed', function (id) {
            $scope.admins.removeWhere(function (u) { return u.userId == id; });
        });

        $interval(function () {
            for (var i = 0; i < $scope.admins.length; i++) {
                var admin = $scope.admins[i];
                admin.lastActive = Date.now() / 1000 - admin.lastActiveAt * 1;
            }
        }, 1000);
    }
})();</script>
<script type="text/ng-template" id="users-widget-directive-template.html">
@include('dashboard.widgets.users-widget-template')
</script>
<script type="text/ng-template" id="users-widget-template.html">
    <users-widget widget='widget'></users-widget>
</script>
<script type="text/ng-template" id="users-footer-template.html" class="text-center">
    <div class="text-center"><a href="/user" target="_blank" class="uppercase">View All Users</a></div>
</script>
