<div class="row">
    <div class="col-md-6 col-sm-12">
        <uib-accordion>
            <uib-accordion-group panel-class="panel-default panel-flat">
                <uib-accordion-heading>
                    <i class="fa fa-plus"></i> Add a New Product Category
                </uib-accordion-heading>
                <nvd-form model="form" on-success="loadproductCategories()" action="/product_category">
                    <nvd-form-element field="category_name">
                        <input type="text" class="form-control" ng-model="form.category_name"
                               placeholder="Enter Category Name"/>
                    </nvd-form-element>
                    <nvd-form-element field="status">
                        <select class="form-control"
                                ng-model="form.status">
                            <option value="">--Category status--</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </nvd-form-element>
                    <button type="submit" class="btn btn-primary btn-flat">Create</button>
                </nvd-form>
            </uib-accordion-group>
        </uib-accordion>
    </div>
</div>