<?php
/* @var $gen \Nvd\Crud\Commands\Crud */
/* @var $fields [] */
?>
'use strict';
angular.module("myApp", [
    'CustomDirectives',
    'xeditable',
    'toaster'
]).run(function (editableOptions) {
    editableOptions.theme = 'bs3'; // bootstrap3 theme. Can be also 'bs2', 'default'
});

angular.module("myApp").controller('MainController',MainController);

function MainController($http,$scope){
    $scope.<?= str_plural($gen->modelVariableName()) ?> = [];
    $scope.loading<?= studly_case($gen->tableName) ?> = false;
    $scope.form = {};

    $scope.load<?=studly_case($gen->tableName)?> = function () {
        $scope.loading<?= studly_case($gen->tableName)?> = true;
        $http.get("/<?= $gen->route() ?>?sort=id&sortType=desc").then(function (response) {
            $scope.<?= str_plural($gen->modelVariableName()) ?> = response.data.data;
            $scope.loading<?= studly_case($gen->tableName)?> = false;
        });
    };

    $scope.load<?= studly_case($gen->tableName)?>();
}