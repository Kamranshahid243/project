<?php
/* @var $gen \Nvd\Crud\Commands\Crud */
/* @var $field */
/* @var $ngModel */
?>
<?php
    $defaultAttrs = 'class="form-control" ng-model="'. $ngModel.'"';
    $placeholder = 'placeholder="' . ucwords(str_replace("_", " ", $field->name)) . '"';
?>
<nvd-form-element field="<?= $field->name ?>">
    <label for="<?= $field->name ?>"><?= ucwords(str_replace("_", " ", $field->name)) ?></label>
<?php if ($field->type == 'enum') { ?>
    <select ng-options="item for item in ['<?= join("','", $field->enumValues) ?>']" <?= $defaultAttrs ?>>
        <option value=""><?= ucwords(str_replace("_", " ", $field->name)) ?></option>
    </select>
<?php } elseif (preg_match("/_id$/", $field->name)) {
    $name = str_replace("_id", "", $field->name);
    $url = str_slug($name);
    ?>
    <remote-select
        url="/<?= $url ?>"
        ng-model="<?= $ngModel ?>"
        label-field="title" value-field="id"
        placeholder="<?= ucwords(str_replace("_", " ", $name)) ?>"
    ></remote-select>
<?php } elseif ($field->type == 'text') { ?>
    <textarea <?= $defaultAttrs ?> <?= $placeholder ?>></textarea>
<?php } elseif (preg_match("/date|dob/", $field->name)) { ?>
    <input <?= $defaultAttrs ?> <?= $placeholder ?> bs-datepicker data-date-format="yyyy-MM-dd"
                                                    data-autoclose="1"/>
<?php } else { ?>
    <input <?= $defaultAttrs ?> <?= $placeholder ?>/>
<?php } ?>
</nvd-form-element>
