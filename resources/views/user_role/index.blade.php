@extends("layouts.master")
@section('title') User Roles @stop
@section('content')
    <div class="row" ng-controller="MainController" show-loader="state.loading.roles">
        <div class="col-sm-12">
            @include('user_role.create')
            <div class="box">
                <div class="box-options">
                    <a href="javascript:void(0)" class="box-option"
                       ng-if="roles.length">
                        <i to-csv="roles"
                           csv-file-name="user-roles.csv"
                           csv-fields="csvFields"
                           class="fa fa-download"
                           uib-tooltip="Download data as CSV"
                           tooltip-placement="left"></i>
                    </a>&nbsp;
                    <a href="javascript:void(0)" ng-click="loadRoles()" class="box-option">
                        <i class="fa fa-sync-alt"
                           uib-tooltip="Reload records"
                           tooltip-placement="left"></i>
                    </a>&nbsp;
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <h4>Roles</h4>
                            <div class="list-group">
                                <a ng-repeat="role in roles"
                                   ng-class="{active: state.selectedRole == role}"
                                   ng-click="state.selectedRole = role"
                                   href="#"
                                   class="list-group-item"
                                >@{{role.role}}</a>
                            </div>
                        </div>
                        <div class="col-sm-8 col-sm-offset-1">
                            <h4>Details</h4>
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th width="30%">Title</th>
                                    <td>@{{ state.selectedRole.role }}</td>
                                </tr>
                                <tr>
                                    <th width="30%">
                                        <span uib-tooltip="Should the system allow read access to the pages that are not listed here?">
                                            Default Read Access
                                        </span>
                                    </th>
                                    <td>
                                        <n-editable type="select" name="default_read_access"
                                                    value="state.selectedRole.default_read_access"
                                                    url="/user-role/@{{state.selectedRole.id}}"
                                                    dd-options="[{default_read_access: 'Granted'}, {default_read_access: 'Declined'}]"
                                                    dd-value-field="default_read_access"
                                                    dd-label-field="default_read_access"
                                        ></n-editable>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="30%">
                                        <span uib-tooltip="Should the system allow update / delete access to the pages that are not listed here?">
                                            Default Update / Delete Access
                                        </span>
                                    </th>
                                    <td>
                                        <n-editable type="select" name="default_cud_access"
                                                    value="state.selectedRole.default_cud_access"
                                                    url="/user-role/@{{state.selectedRole.id}}"
                                                    dd-options="[{default_cud_access: 'Granted'}, {default_cud_access: 'Declined'}]"
                                                    dd-value-field="default_cud_access"
                                                    dd-label-field="default_cud_access"
                                        ></n-editable>
                                    </td>
                                </tr>
                            </table>

                            <h4>Page Access Details</h4>
                            <nvd-ng-tree tree="pagesTree"></nvd-ng-tree>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-sm-1 col-sm-offset-4">
                        <button class="btn btn-primary form-control" ng-click="saveRole()">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <toaster-container></toaster-container>
    </div>
@endsection
@include('user_role.user_role-ng-app')