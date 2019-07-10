'use strict';
angular.module("myApp").controller('MainController',MainController);

function MainController($http,$scope){
    $scope.<?= str_plural($gen->modelVariableName()) ?> = [];
    $scope.loading<?= $gen->titlePlural() ?> = false;
    $scope.form = {};

    $scope.load<?= $gen->titlePlural() ?> = function () {
        $scope.loading<?= $gen->titlePlural() ?> = true;
        $http.get("/<?= $gen->route() ?>?sort=id&sortType=desc").then(function (response) {
            $scope.<?= str_plural($gen->modelVariableName()) ?> = response.data.data;
            $scope.loading<?= $gen->titlePlural() ?> = false;
        });
    };

    $scope.load<?= $gen->titlePlural() ?>();
}