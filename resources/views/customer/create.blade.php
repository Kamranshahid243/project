<div class="row">
    <div class="col-md-6 col-sm-12">
        <uib-accordion>
            <uib-accordion-group panel-class="panel-default panel-flat">
                <uib-accordion-heading>
                    <i class="fa fa-plus"></i> Add a New Customer
                </uib-accordion-heading>
                <nvd-form model="form" on-success="loadCustomers()" action="/customers">
                    <nvd-form-element field="customer_name">
                        <input class="form-control" ng-model="form.customer_name" placeholder="Name"/>
                    </nvd-form-element>
                    <nvd-form-element field="customer_address">
                        <input class="form-control" ng-model="form.customer_address" placeholder="Address"/>
                    </nvd-form-element>

                    <nvd-form-element field="customer_email">
                        <input type="email" class="form-control" ng-model="form.customer_email" placeholder="Email"/>
                    </nvd-form-element>

                    <nvd-form-element field="customer_phone">
                        <input type="text" class="form-control" ng-model="form.customer_phone" placeholder="(e.g 03xxxxxxxxx)" maxlength="11"/>
                    </nvd-form-element>

                    <nvd-form-element field="shop_id" >
                        <select class="form-control"
                                ng-model="form.shop_id" >
                            <option value="">--Shop--</option>
                            <option value="@{{ x.shop_id }}" ng-repeat="x in allShops">@{{ x.shop_name }}</option>

                        </select>
                    </nvd-form-element>

                    <nvd-form-element field="customer_type">
                        <select ng-options="item for item in ['Shopkeeper','Consumer']" class="form-control"
                                ng-model="form.customer_type">
                            <option value="">--Customer type--</option>
                        </select>
                    </nvd-form-element>
                    <nvd-form-element field="status">
                        <select ng-options="item for item in ['Active','Inactive']" class="form-control"
                                ng-model="form.status">
                            <option value="">--Customer status--</option>
                        </select>
                    </nvd-form-element>

                    <button type="submit" class="btn btn-primary btn-flat">Create</button>
                </nvd-form>
            </uib-accordion-group>
        </uib-accordion>
    </div>
</div>