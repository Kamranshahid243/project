<div class="col-md-9">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#password" data-toggle="tab">Password</a></li>
        </ul>
        <div class="tab-content">
            <div class="active tab-pane" id="password">
                <h4>Change Password</h4>

                <nvd-form model="passwordForm" action="/user/change-password">
                    <nvd-form-element field="currentPassword">
                        <input type="password" class="form-control" ng-model="passwordForm.currentPassword" placeholder="Current Password"/>
                    </nvd-form-element>

                    <nvd-form-element field="newPassword">
                        <input type="password" class="form-control" ng-model="passwordForm.newPassword" placeholder="New Password"/>
                    </nvd-form-element>

                    <nvd-form-element field="newPassword_confirmation">
                        <input type="password" class="form-control" ng-model="passwordForm.newPassword_confirmation" placeholder="Confirm Password"/>
                    </nvd-form-element>

                    <button type="submit" class="btn btn-primary btn-flat">Update</button>
                </nvd-form>
            </div>
        </div>
    </div>
</div>