<?php
/* @var $gen \Nvd\Crud\Commands\Crud */
/* @var $fields [] */
?>
<div class="row">
    <div class="col-md-6 col-sm-12">
        <uib-accordion>
            <uib-accordion-group panel-class="panel-default panel-flat">
                <uib-accordion-heading>
                    <i class="fa fa-plus"></i> Add a New <?= $gen->titleSingular() ?>
                </uib-accordion-heading>
                <nvd-form model="form" on-success="load<?=studly_case($gen->tableName) ?>()" action="/<?= $gen->route() ?>">
                    <?php foreach ($fields as $field) { ?>
                    <?php if (!\Nvd\Crud\Db::isGuarded($field->name)) { ?>
    <?= view("vendor.crud.ng-templates.common.input-markup",['field' => $field, 'gen' => $gen, 'ngModel' => 'form.'.$field->name]) ?>
                    <?php } ?>
                    <?php } ?>
                    <button type="submit" class="btn btn-primary btn-flat">Create</button>
                </nvd-form>
            </uib-accordion-group>
        </uib-accordion>
    </div>
</div>