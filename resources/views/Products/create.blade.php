<div class="row">
    <div class="col-md-6 col-sm-12">
        <uib-accordion>
            <uib-accordion-group panel-class="panel-default panel-flat">
                <uib-accordion-heading>
                    <i class="fa fa-plus"></i> Add a New Product
                </uib-accordion-heading>
                <nvd-form model="form" on-success="loadProducts()" action="/addProduct">
                    <nvd-form-element field="shop_id">
                        <select class="form-control" ng-model="form.shop_id"
                                ng-options="s.shop_id as s.shop_name for s in shops">
                            <option value="">All Shops</option>
                        </select>
                    </nvd-form-element>

                    <nvd-form-element field="product_name">
                        <input class="form-control" type="text" ng-model="form.product_name" placeholder="Product Name">
                    </nvd-form-element>

                    <nvd-form-element field="product-code">
                        <input class="form-control" type="text" ng-model="form.product_code" placeholder="Product Code">
                    </nvd-form-element>

                    <nvd-form-element field="product-description">
                        <input class="form-control" type="text" ng-model="form.product_description"
                               placeholder="Product description">
                    </nvd-form-element>

                    <nvd-form-element field="available-quantity">
                        <input class="form-control" type="text" ng-model="form.available_quantity"
                               placeholder="Available Quantity">
                    </nvd-form-element>

                    <nvd-form-element field="unit_price">
                        <input class="form-control" type="text" ng-model="form.unit_price"
                               placeholder="Unit Price">
                    </nvd-form-element>

                    <button type="submit" class="btn btn-primary btn-flat" ng-click="loadProducts()">Create</button>
                </nvd-form>
            </uib-accordion-group>
        </uib-accordion>
    </div>
</div>