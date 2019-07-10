<div class="row">
    <div class="col-md-6 col-sm-12">
        <uib-accordion>
            <uib-accordion-group panel-class="panel-default panel-flat">
                <uib-accordion-heading>
                    <i class="fa fa-plus"></i> Add a New User Role
                </uib-accordion-heading>
                <nvd-form model="form" on-success="loadRoles()" action="/user-role">
                    <nvd-form-element field="role">
                        <input class="form-control" ng-model="form.role" placeholder="Role"/>
                    </nvd-form-element>

                    <nvd-form-element field="default_read_access">
                        <select ng-options="item for item in ['Granted','Declined']" class="form-control"
                                ng-model="form.default_read_access">
                            <option value="">Default Read Access</option>
                        </select>
                    </nvd-form-element>

                    <nvd-form-element field="default_cud_access">
                        <select ng-options="item for item in ['Granted','Declined']" class="form-control"
                                ng-model="form.default_cud_access">
                            <option value="">Default Cud Access</option>
                        </select>
                    </nvd-form-element>

                    <button type="submit" class="btn btn-primary btn-flat">Create</button>
                </nvd-form>
            </uib-accordion-group>
        </uib-accordion>
    </div>
</div>