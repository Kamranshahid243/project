<div class="row">
    <div class="col-md-6 col-sm-12">
        <uib-accordion>
            <uib-accordion-group panel-class="panel-default panel-flat">
                <uib-accordion-heading>
                    <i class="fa fa-plus"></i> Add a New Vendor
                </uib-accordion-heading>
                <nvd-form model="form" on-success="loadVendors()" action="/addVendor">
                    <nvd-form-element field="vendor_name">
                        <input class="form-control" type="text" ng-model="form.vendor_name" placeholder="Vendor Name">
                    </nvd-form-element>

                    <nvd-form-element field="vendor-address">
                        <input class="form-control" type="text" ng-model="form.vendor_address"
                               placeholder="Vendor Adress">
                    </nvd-form-element>

                    <nvd-form-element field="vendor_phone">
                        <input class="form-control" type="text" ng-model="form.vendor_phone"
                               placeholder="Vendor Phone#">
                    </nvd-form-element>

                    <nvd-form-element field="vendor_email">
                        <input class="form-control" type="text" ng-model="form.vendor_email"
                               placeholder="Enter Vendor Email">
                    </nvd-form-element>
                    <nvd-form-element field="vendor_status">
                        <select ng-options="item for item in ['Enabled','Disabled']" class="form-control"
                                ng-model="form.vendor_status">
                            <option value="">--Vendor status--</option>
                        </select>
                    </nvd-form-element>
                    <button type="submit" class="btn btn-primary btn-flat">Create</button>
                </nvd-form>
            </uib-accordion-group>
        </uib-accordion>
    </div>
</div>