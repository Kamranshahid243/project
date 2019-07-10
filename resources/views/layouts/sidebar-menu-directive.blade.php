<script>
    (function () {
        'use strict';
        var app = angular.module('myApp');
        app.directive('attributes', function () {
            return {
                restrict: 'A',
                link: function (scope, elem, attrs) {
                    if (attrs.attributes) {
                        var attributes = angular.fromJson(attrs.attributes);
                        angular.forEach(attributes, function (attribute) {
                            elem.attr(attribute.attribute, attribute.value);
                        });
                    }
                }
            };
        });

        app.directive('sidebarMenu', function () {
            return {
                restrict: 'E',
                require: '^^attributes',
                controller: SidebarMenuController,
                templateUrl: "sidebar-menu-directive-template.html"
            };
        });

        function SidebarMenuController($scope, $http, toaster) {
            $scope.loadingMenu = false;
            $scope.menu = [];
            $scope.state = {
                toggle: function (prop, value) {
                    var state = this;
                    if (state[prop] == value) state[prop] = null;
                    else state[prop] = value;
                }
            };

            $scope.loadMenu = function () {
                if ($scope.loadingMenu) return;
                $scope.loadingMenu = true;
                $http.get("/load-menu").then(function (response) {
                    $scope.menu = response.data;
                }).catch(function (response) {
                    toaster.pop('error', 'Error while loading sidebar menu. Try refresh.')
                }).then(function () {
                    $scope.loadingMenu = false;
                });
            };
            $scope.loadMenu();
        }
    })();
</script>
<script type="text/ng-template" id="sidebar-menu-directive-template.html">
    <form action="#" method="get" class="sidebar-form">
        <input type="text" ng-model="query" class="form-control" placeholder="Search..." ng-disabled="loadingMenu">
    </form>
    <ul class="sidebar-menu">
        <li ng-repeat="level1 in menu | filter:query" ng-if="!loadingMenu">
            @include('layouts.sidebar-menu-item', ['name' => 'level1'])
            <ul class="treeview-menu" ng-if="level1.child">
                <li ng-repeat="level2 in level1.child">
                    @include('layouts.sidebar-menu-item', ['name' => 'level2'])
                    <ul class="treeview-menu" ng-if="level2.child">
                        <li ng-repeat="level3 in level2.child">
                            @include('layouts.sidebar-menu-item', ['name' => 'level3'])
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li ng-if="loadingMenu"><a href="#">Loading...</a></li>
    </ul>
</script>