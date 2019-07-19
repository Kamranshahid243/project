@extends("layouts.master")
@section('title') Users @stop
@section('content')
    <div class="row" ng-controller="MainController" show-loader="state.loadingUsers">
        <div class="col-sm-12">
            @include('user.create')
            <div class="box">
                <bulk-assigner target="users" url="/user/bulk-edit">
                    <bulk-assigner-field field="bulkAssignerFields.status">
                        <select ng-options="item for item in ['Enabled','Disabled']" class="form-control"
                                ng-model="bulkAssignerFields.status.value">
                            <option value="">Status</option>
                        </select>
                    </bulk-assigner-field>
                    <bulk-assigner-field field="bulkAssignerFields.user_role_id">
                        <remote-select
                                url="/user-role"
                                ng-model="bulkAssignerFields.user_role_id.value"
                                label-field="role" value-field="id"
                                placeholder="User Role"
                        ></remote-select>
                    </bulk-assigner-field>
                </bulk-assigner>
                <div class="box-options">
                    <a href="javascript:void(0)" class="box-option"
                       ng-if="users.length">
                        <i to-csv="users"
                           csv-file-name="users.csv"
                           csv-fields="csvFields"
                           class="fa fa-download"
                           uib-tooltip="Download data as CSV"
                           tooltip-placement="left"></i>
                    </a>&nbsp;
                    <a href="javascript:void(0)" ng-click="loadUsers()" class="box-option">
                        <i class="fa fa-sync-alt"
                           uib-tooltip="Reload records"
                           tooltip-placement="left"></i>
                    </a>&nbsp;
                    <bulk-assigner-delete-btn target="users"
                                              url="/user/bulk-delete"
                    ></bulk-assigner-delete-btn>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover grid-view-tbl">
                        <thead>
                        <tr class="search-row">
                            <td><b>Search By:</b></td>
                            <form class="search-form form-material">
                                <td><input class="form-control" ng-model="state.params.name" placeholder="User Name"/></td>
                                <td><input class="form-control" ng-model="state.params.email" placeholder="Shop Email"/></td>
                                <td>
                                    <select ng-options="item for item in ['Enabled','Disabled']" class="form-control"
                                            ng-model="state.params.status">
                                        <option value="">Status</option>
                                    </select>
                                </td>
                                <td>
                                    <remote-select
                                        url="/user-role"
                                        ng-model="state.params.user_role_id"
                                        label-field="role" value-field="id"
                                        placeholder="User Role"
                                    ></remote-select>
                                </td>
                                <td></td>
                            </form>
                        </tr>
                        <tr class="header-row">
                            <th>
                                <bulk-assigner-toggle-all target="users"></bulk-assigner-toggle-all>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="name"
                                        field-label="Name"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="email"
                                        field-label="Email"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="status"
                                        field-label="Status"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>
                                <filter-btn
                                        field-name="user_role_id"
                                        field-label="User Role"
                                        model="state.params"
                                ></filter-btn>
                            </th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="user in users"
                            ng-class="{'bg-aqua-active': user.$selected}">
                            <th>
                                <bulk-assigner-checkbox target="user"></bulk-assigner-checkbox>
                            </th>
                            <td>
                                <n-editable type="text" name="name"
                                            value="user.name"
                                            url="/user/@{{user.id}}"
                                ></n-editable>
                            </td>
                            <td>@{{ user.email }}
                                {{--<n-editable type="text" name="email"--}}
                                            {{--value="user.email"--}}
                                            {{--url="/user/@{{user.id}}"--}}
                                {{--></n-editable>--}}
                            </td>
                            <td ng-if="user.status=='Enabled'" style="color: green; font-weight: bold;">
                                <n-editable type="select" name="status"
                                            value="user.status"
                                            url="/user/@{{user.id}}"
                                            dd-options="[{o:'Enabled'},{o:'Disabled'}]"
                                            dd-label-field="o"
                                            dd-value-field="o"
                                ></n-editable>
                            </td>
                            <td ng-if="user.status=='Disabled'" style="color: red; font-weight: bold;">
                                <n-editable type="select" name="status"
                                            value="user.status"
                                            url="/user/@{{user.id}}"
                                            dd-options="[{o:'Enabled'},{o:'Disabled'}]"
                                            dd-label-field="o"
                                            dd-value-field="o"
                                ></n-editable>
                            </td>
                            <td>
                                <n-editable type="select" name="user_role_id"
                                            value="user.user_role_id"
                                            url="/user/@{{user.id}}"
                                            dd-options-url="/user-role"
                                            dd-label-field="role"
                                            dd-value-field="id"
                                ></n-editable>
                            </td>
                            <td>
                                <delete-btn action="/user/@{{user.id}}" on-success="loadUsers()">
                                    <i class="fa fa-trash"></i>
                                </delete-btn>
                            </td>
                        </tr>

                        <tr class="alert alert-warning" ng-if="!users.length && !state.loadingUsers">
                            <td colspan="6">No records found.</td>
                        </tr>
                        </tbody>
                    </table>
                    <hr>
                    <pagination state="state" records-info="recordsInfo"></pagination>
                </div>
            </div>
        </div>
        <toaster-container></toaster-container>
    </div>
@endsection
@include('user.user-ng-app')