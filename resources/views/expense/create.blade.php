<div class="row">
    <div class="col-md-6 col-sm-12">
        <uib-accordion>
            <uib-accordion-group panel-class="panel-default panel-flat">
                <uib-accordion-heading>
                    <i class="fa fa-plus"></i> Add a New Expense
                </uib-accordion-heading>
                <nvd-form model="form" on-success="loadExpenses()" action="/expenses">
                    <nvd-form-element field="date">
                        <input type="date" class="form-control" ng-model="form.date">
                    </nvd-form-element>
                    <nvd-form-element field="category_id">
                        <select class="form-control" ng-model="form.category_id">
                            <option value="">--select Category--</option>
                            <option ng-show="category.status=='Active'" value="@{{ category.id }}"
                                    ng-repeat="category in allCategories">@{{ category.cat_name }}
                            </option>
                        </select>
                    </nvd-form-element>
                    <nvd-form-element field="cost">
                        <input type="number" class="form-control" ng-model="form.cost" placeholder="Enter Expense Price">
                    </nvd-form-element>
                    <button type="submit" class="btn btn-primary btn-flat">Create</button>
                </nvd-form>
            </uib-accordion-group>
        </uib-accordion>
    </div>
</div>