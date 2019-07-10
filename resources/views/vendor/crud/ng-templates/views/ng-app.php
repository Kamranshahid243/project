<?php
/* @var $gen \Nvd\Crud\Commands\Crud */
/* @var $fields [] */
?>
@push('head-scripts')
<script>
(function () {
angular.module("myApp").controller('MainController', MainController);

function MainController ($http, $scope, PageState, toaster) {
    $scope.<?= str_plural($gen->modelVariableName()) ?> = [];
    $scope.recordsInfo = {};
    $scope.form = {};
    var state = $scope.state = PageState;
    state.loading<?=studly_case($gen->tableName)?> = false;

    $scope.load<?=studly_case($gen->tableName)?> = function () {
        if ($scope.loading<?= studly_case($gen->tableName)?>) return;
        state.loading<?= studly_case($gen->tableName)?> = true;
        $http.get("/<?= $gen->route() ?>", {params: state.params})
            .then(function (response) {
                $scope.<?= str_plural($gen->modelVariableName()) ?> = response.data.data;
                $scope.recordsInfo = response.data;
            })
            .catch(function (res) {
                toaster.pop('error', 'Error while loading <?=$gen->titlePlural()?>', res.data);
            })
            .then(function () {
                state.loading<?= studly_case($gen->tableName)?> = false;
            });
    };

    $scope.$watch('state.params', $scope.load<?=studly_case($gen->tableName)?>, true);

    $scope.bulkAssignerFields = {
    <?php
    foreach ($fields as $field) {
        if (!in_array($field->name, config('crud.skipped-fields'))) {
            $label = ucwords(str_replace('_', ' ', $field->name));
            echo "\t{$field->name}: { name: '{$field->name}', label: '{$label}' },\n\t";
        }
    }
    ?>};

    $scope.csvFields = [
        <?php foreach ($fields as $field) { ?>
{name: '<?= $field->name?>', label: '<?= ucwords(str_replace('_', ' ', $field->name)) ?>'},
        <?php } ?>
    ];
}
})();
</script>
@endpush