<div class="row">
    <div class="col-md-6 col-sm-12">
        <uib-accordion>
            <uib-accordion-group panel-class="panel-default panel-flat">
                <uib-accordion-heading>
                    <i class="fa fa-plus"></i> Add a New User
                </uib-accordion-heading>
                <nvd-form model="form" on-success="loadUsers()" action="/user">
                    <nvd-form-element field="name">
                        <input class="form-control" ng-model="form.name" placeholder="Name"/>
                    </nvd-form-element>

                    <nvd-form-element field="email">
                        <input class="form-control" ng-model="form.email" placeholder="Email"/>
                    </nvd-form-element>

                    <nvd-form-element field="password">
                        <input type="password" class="form-control" ng-model="form.password" placeholder="Password"/>
                    </nvd-form-element>

                    <nvd-form-element field="status">
                        <select ng-options="item for item in ['Enabled','Disabled']" class="form-control"
                                ng-model="form.status">
                            <option value="">Status</option>
                        </select>
                    </nvd-form-element>

                    <nvd-form-element field="user_role_id">
                        <remote-select
                                url="/user-role"
                                ng-model="form.user_role_id"
                                label-field="role" value-field="id"
                                placeholder="User Role"
                        ></remote-select>
                    </nvd-form-element>

                    <button type="submit" class="btn btn-primary btn-flat">Create</button>
                </nvd-form>
            </uib-accordion-group>
        </uib-accordion>
    </div>
</div>