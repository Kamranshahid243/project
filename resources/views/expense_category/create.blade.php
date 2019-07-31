<div class="row">
    <div class="col-md-6 col-sm-12">
        <uib-accordion>
            <uib-accordion-group panel-class="panel-default panel-flat">
                <uib-accordion-heading>
                    <i class="fa fa-plus"></i> Add a New Expense Category
                </uib-accordion-heading>
                <nvd-form model="form" on-success="loadExpenseCategories()" action="/expense-category">
                     <nvd-form-element field="cat_name">
                         <input type="text" class="form-control" ng-model="form.cat_name" placeholder="Enter Category Name"/>
                     </nvd-form-element>
                     <nvd-form-element field="status">
                            <select ng-options="item for item in ['Active','Inactive']" class="form-control"
                                    ng-model="form.status">
                                <option value="">--Category status--</option>
                            </select>
                     </nvd-form-element>
                    <button type="submit" class="btn btn-primary btn-flat">Create</button>
                </nvd-form>
            </uib-accordion-group>
        </uib-accordion>
    </div>
</div>