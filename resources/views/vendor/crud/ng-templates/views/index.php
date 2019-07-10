<?php
/* @var $gen \Nvd\Crud\Commands\Crud */
/* @var $fields [] */
?>
@extends("<?=config('crud.layout')?>")
@section('title') <?= $gen->titlePlural() ?> @stop
@section('content')
<div class="row" ng-controller="MainController">
    <div class="col-sm-12">
        @include('<?= $gen->viewsDirName() ?>.create')
        <div class="box" show-loader="state.loading<?= studly_case($gen->tableName) ?>">
            <bulk-assigner target="<?= str_plural($gen->modelVariableName()) ?>" url="/<?=$gen->route()?>/bulk-edit">
                <?php foreach ($fields as $field) { ?>
                <?php if (!in_array($field->name, config('crud.skipped-fields'))) { ?>
<bulk-assigner-field field="bulkAssignerFields.<?=$field->name?>">
    <?= view("vendor.crud.ng-templates.common.input-markup", ['field' => $field, 'gen' => $gen, 'ngModel' => 'bulkAssignerFields.'.$field->name.'.value']) ?>
</bulk-assigner-field>
                <?php } ?>
                <?php } ?>
            </bulk-assigner>
            <div class="box-options">
                <a href="javascript:void(0)" class="box-option"
                   ng-if="<?= str_plural($gen->modelVariableName()) ?>.length && !loading<?= studly_case($gen->tableName) ?>">
                    <i to-csv="<?= str_plural($gen->modelVariableName()) ?>"
                       csv-file-name="<?= str_slug($gen->titlePlural()) ?>.csv"
                       csv-fields="csvFields"
                       class="fa fa-download"
                       uib-tooltip="Download data as CSV"
                       tooltip-placement="left"></i>
                </a>&nbsp;
                <a href="javascript:void(0)"
                   ng-if="!loading<?= studly_case($gen->tableName) ?>"
                   ng-click="load<?= studly_case($gen->tableName) ?>()" class="box-option">
                    <i class="fa fa-sync-alt"
                       uib-tooltip="Reload records"
                       tooltip-placement="left"></i>
                </a>&nbsp;
                <bulk-assigner-delete-btn target="<?= str_plural($gen->modelVariableName()) ?>" url="/<?= $gen->route() ?>/bulk-delete"></bulk-assigner-delete-btn>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-hover grid-view-tbl">
                    <thead>
                    <tr class="header-row">
                        <th>
                            <bulk-assigner-toggle-all target="<?= str_plural($gen->modelVariableName()) ?>"></bulk-assigner-toggle-all>
                        </th>
                        <?php foreach ($fields as $field) { ?>
                            <?php if (!in_array($field->name, config('crud.skipped-fields'))) { ?>
                            <th>
                                <filter-btn
                                    field-name="<?= $field->name ?>"
                                    field-label="<?= ucwords(str_replace('_', ' ', $field->name)) ?>"
                                    model="state.params"
                                    search-field="true"
                                ></filter-btn>
                            </th>
                            <?php } ?>
                        <?php } ?>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="<?= $gen->modelVariableName() ?> in <?= str_plural($gen->modelVariableName()) ?>"
                        ng-class="{'bg-aqua-active': <?= $gen->modelVariableName() ?>.$selected}">
                        <th>
                            <bulk-assigner-checkbox target="<?= $gen->modelVariableName() ?>"></bulk-assigner-checkbox>
                        </th>
                        <?php $fieldCount = count($fields) + 2; foreach ($fields as $field) { ?>
                            <?php if (!in_array($field->name, config('crud.skipped-fields'))) { ?>
                                <td>
                                <n-editable type="text" name="<?= $field->name?>"
                                    value="<?= $gen->modelVariableName() ?>.<?= $field->name ?>"
                                    url="/<?=$gen->route()?>/@{{<?=$gen->modelVariableName() ?>.id}}"
                                ></n-editable>
                                </td>
                            <?php } else { $fieldCount --;} ?>
                        <?php } ?>
                <td><delete-btn action="/<?=$gen->route()?>/@{{<?=$gen->modelVariableName()?>.id}}" on-success="load<?=studly_case($gen->tableName)?>()"><i class="fa fa-trash"></i>
                </delete-btn></td>
                    </tr>

                    <tr class="alert alert-warning" ng-if="!<?= str_plural($gen->modelVariableName()) ?>.length && !state.loading<?= studly_case($gen->tableName) ?>">
                        <td colspan="<?= $fieldCount ?>">No records found.</td>
                    </tr>
                    </tbody>
                </table>
                <hr>
                <pagination state="state" records-info="recordsInfo"></pagination>
            </div>
        </div>
    </div>
</div>
@endsection
@include('<?=$gen->viewsDirName()?>.<?= $gen->viewsDirName() ?>-ng-app')