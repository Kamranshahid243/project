<div class="row">
    <div class="col-md-6 col-sm-12">
        <uib-accordion>
            <uib-accordion-group panel-class="panel-default panel-flat">
                <uib-accordion-heading>
                    <i class="fa fa-plus"></i> Add a New Purchase
                </uib-accordion-heading>
                <nvd-form model="form" on-success="loadPurchases()" action="/purchases">
                    <nvd-form-element field="vendor_id">
                        <select class="form-control" ng-model="form.vendor_id"
                                ng-options="vendor.vendor_id as vendor.vendor_name for vendor in vendors">
                            <option value="">--select vendor--</option>
                        </select>
                    </nvd-form-element>

                    <nvd-form-element field="product_name">
                        <input class="form-control" type="text" ng-model="form.product_name" placeholder="Product Name">
                    </nvd-form-element>

                    <nvd-form-element field="product_code">
                        <input class="form-control" type="text" ng-model="form.product_code" placeholder="Product Code">
                    </nvd-form-element>

                    <nvd-form-element field="category_id">
                        <select class="form-control" ng-model="form.category_id">
                            <option value="">--select Category--</option>
                            <option ng-show="category.status=='1'" value="@{{ category.id }}"
                                    ng-repeat="category in categories">@{{ category.category_name }}
                            </option>
                        </select>
                    </nvd-form-element>

                    <nvd-form-element field="product_description">
                        <input class="form-control" type="text" ng-model="form.product_description"
                               placeholder="Product description">
                    </nvd-form-element>

                    <nvd-form-element field="quantity">
                        <input class="form-control" type="number" ng-model="form.quantity"
                               placeholder="Quantity" min="1">
                    </nvd-form-element>

                    <nvd-form-element field="original_cost">
                        <input class="form-control" type="number" ng-model="form.original_cost"
                               placeholder="Product Net Price" min="1">
                    </nvd-form-element>
                    <nvd-form-element field="purchase_cost">
                        <input class="form-control" type="number" ng-model="form.purchase_cost"
                               placeholder="Product Purchase Price" min="1">
                    </nvd-form-element>
                    <nvd-form-element field="customer_cost">
                        <input class="form-control" type="number" ng-model="form.customer_cost"
                               placeholder="Product Selling Price" min="1">
                    </nvd-form-element>
                    <span ng-show="form.quantity!=NULL && form.purchase_cost!=NULL" style="color: red;">@{{ "*Total Payable Amount (PKR 0-" + (form.purchase_cost * form.quantity ) + ")" }}</span>
                    <nvd-form-element field="paid">
                        <input class="form-control" type="number" ng-model="form.paid"
                               placeholder="Paid Amount" min="0" max="@{{ form.purchase_cost * form.quantity }}">
                    </nvd-form-element>
                    <nvd-form-element field="product_status">
                        <select ng-options="item for item in ['Available','Unavailable']" class="form-control"
                                ng-model="form.product_status">
                            <option value="">--product status--</option>
                        </select>
                    </nvd-form-element>
                    <nvd-form-element field="date">
                        <input class="form-control" type="date" ng-model="form.date"
                               placeholder="Purchase Date">
                    </nvd-form-element>
                    <button type="submit" class="btn btn-primary btn-flat" ng-click="loadPurchases()">Create</button>
                </nvd-form>
            </uib-accordion-group>
        </uib-accordion>
    </div>
</div>