<script>
    (function () {
        'use strict';
        angular.module('myApp', [
            'toaster',
            'pusher-angular',
            'ui.bootstrap',
            'xeditable',
            'ngSanitize',
            'ui.select',
            'moment-picker',
            'CustomAngular'
        ]).run(function (editableOptions) {
            editableOptions.theme = 'bs3'; // bootstrap3 theme. Can be also 'bs2', 'default'
        }).config(function ($uibTooltipProvider) {
            $uibTooltipProvider.options({
                'appendToBody': true
            });
        }).controller('LayoutController', LayoutController);

        function LayoutController($http, $scope) {

        }

    })();
</script>
