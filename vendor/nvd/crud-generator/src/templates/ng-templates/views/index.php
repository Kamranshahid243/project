<?php
/* @var $gen \Nvd\Crud\Commands\Crud */
/* @var $fields [] */
?>
@extends('layouts.app')

{{--full width page--}}
@push('body-classes') site-menubar-keep site-menubar-hide @endpush

@push('styles')
<style>
    .main-wrapper {
        margin-top: 1em;
    }
</style>
@endpush

@section('content')

<div class="page animsition">

    @include('settings.aside')

    <div class="page-main">

        @include('common.init-ng-app',['app' => '<?=$gen->ngAppDirName()?>','appFile' => 'app'])
        <div class="page-header">
            <h1 class="page-title"><?= $gen->titlePlural() ?></h1>
        </div>

        <div class="page-content">
            <p>This page lists the <?= $gen->titlePlural() ?> that are available in {{$schoolSetting->school_name}}.</p>

            <div class="row">
                <nvd-form model="form" on-success="load<?= studly_case($gen->tableName) ?>()" action="/<?= $gen->route() ?>" class="col-sm-4">
                    <nvd-form-element field="category">
                        <div class="input-group">
                            <div class="form-control-wrap">
                                <input class="form-control" placeholder="Add a New <?= $gen->titleSingular() ?>" ng-model="form.category">
                            </div>
                            <span class="input-group-btn">
                              <button class="btn btn-primary waves-effect waves-light" type="submit">
                                  <i class="fa fa-plus"></i> Add
                              </button>
                            </span>
                        </div>
                    </nvd-form-element>
                </nvd-form>
            </div>

            <div class="main-wrapper row" show-loader="loading<?= studly_case($gen->tableName) ?>">
                <div class="col-sm-3" ng-repeat="<?=$gen->modelVariableName()?> in <?= str_plural($gen->modelVariableName()) ?>">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <n-editable type="text" name="category" value="<?=$gen->modelVariableName()?>.category"
                                            url="/<?= $gen->route() ?>/@{{<?= $gen->modelVariableName() ?>.id}}"></n-editable>
                            </h3>
                            <div class="panel-actions">
                                <delete-btn action="/<?= $gen->route() ?>/@{{<?= $gen->modelVariableName() ?>.id}}" on-success="load<?= studly_case($gen->tableName) ?>()">
                                    <i class="fa fa-times"></i>
                                </delete-btn>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endNgApp

        </div>
    </div>
</div>
@endsection