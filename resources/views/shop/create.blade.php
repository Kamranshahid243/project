<div class="row">
    <div class="col-md-6 col-sm-12">
        <uib-accordion>
            <uib-accordion-group panel-class="panel-default panel-flat">
                <uib-accordion-heading>
                    <i class="fa fa-plus"></i> Add a New Shop
                </uib-accordion-heading>
                <nvd-form model="form" on-success="loadShops()" action="/shops">
                    <nvd-form-element field="shop_name">
                        <input class="form-control" ng-model="form.shop_name" placeholder="Shop Name"/>
                    </nvd-form-element>

                    <nvd-form-element field="shop_address">
                        <input class="form-control" ng-model="form.shop_address" placeholder="Shop Address"/>
                    </nvd-form-element>

                    <nvd-form-element field="shop_type">
                        <select ng-options="item for item in ['Wholesale','Retail']" class="form-control"
                                ng-model="form.shop_type">
                            <option value="">--Shop type--</option>
                        </select>
                    </nvd-form-element>

                    <nvd-form-element field="printer_type">
                        <select ng-options="item for item in ['Thermal','Laser']" class="form-control"
                                ng-model="form.printer_type">
                            <option value="">--Printer type--</option>
                        </select>
                    </nvd-form-element>
                    <nvd-form-element field="shop_status">
                        <select ng-options="item for item in ['Active','Inactive']" class="form-control"
                                ng-model="form.shop_status">
                            <option value="">--Shop status--</option>
                        </select>
                    </nvd-form-element>

                    <button type="submit" class="btn btn-primary btn-flat">Create</button>
                </nvd-form>
            </uib-accordion-group>
        </uib-accordion>
    </div>
</div>