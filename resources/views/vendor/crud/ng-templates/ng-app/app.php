<?php
/* @var $gen \Nvd\Crud\Commands\Crud */
/* @var $fields [] */
?>
'use strict';
angular.module("myApp", [
    'CustomAngular',
    'xeditable',
    'toaster',
    'ngAnimate',
    'ui.bootstrap',
    'mgcrea.ngStrap'
]).run(function (editableOptions) {
    editableOptions.theme = 'bs3'; // bootstrap3 theme. Can be also 'bs2', 'default'
});

angular.module("myApp").controller('MainController',MainController);

function MainController($http,$scope,PageState){
    $scope.<?= str_plural($gen->modelVariableName()) ?> = [];
    $scope.recordsInfo = {};
    $scope.loading<?= studly_case($gen->tableName) ?> = false;
    $scope.form = {};
    var state = $scope.state = PageState;

    $scope.load<?=studly_case($gen->tableName)?> = function () {
        $scope.loading<?= studly_case($gen->tableName)?> = true;
        $http.get("/<?= $gen->route() ?>", {params: state.params}).then(function (response) {
            $scope.<?= str_plural($gen->modelVariableName()) ?> = response.data.data;
            $scope.loading<?= studly_case($gen->tableName)?> = false;
            $scope.recordsInfo = response.data;
        });
    };

    $scope.$watch('state', $scope.load<?=studly_case($gen->tableName)?>, true);
}
