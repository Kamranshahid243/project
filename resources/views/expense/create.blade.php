<div class="row">
    <div class="col-md-6 col-sm-12">
        <uib-accordion>
            <uib-accordion-group panel-class="panel-default panel-flat">
                <uib-accordion-heading>
                    <i class="fa fa-plus"></i> Add a New Expense
                </uib-accordion-heading>
                <nvd-form model="form" on-success="loadEspenses()" action="/expenses">
                    <nvd-form-element field="shop_id">
                        <select class="form-control" ng-model="form.shop_id">
                            <option value="">--select shop--</option>
                            <option ng-show="shop.shop_status=='Active'" value="@{{ shop.shop_id }}" ng-repeat="shop in allShops">@{{ shop.shop_name }}</option>
                        </select>
                    </nvd-form-element>
                    <nvd-form-element field="rent">
                        <input type="number" class="form-control" ng-model="form.rent" placeholder="Enter rent in Rs">
                    </nvd-form-element>

                    <nvd-form-element field="salaries">
                        <input type="number" class="form-control" ng-model="form.salaries" placeholder="Enter salaries in Rs"/>
                    </nvd-form-element>

                    <nvd-form-element field="refreshment">
                        <input type="number" class="form-control" ng-model="form.refreshment" placeholder="Enter refreshment in Rs"/>
                    </nvd-form-element>
                    <nvd-form-element field="drawing">
                        <input type="number" class="form-control" ng-model="form.drawing" placeholder="Enter drawing in Rs"/>
                    </nvd-form-element>
                    <nvd-form-element field="loss">
                        <input type="number" class="form-control" ng-model="form.loss" placeholder="Enter loss in Rs"/>
                    </nvd-form-element>
                    <nvd-form-element field="bills">
                        <input type="number" class="form-control" ng-model="form.bills" placeholder="Enter bills in Rs"/>
                    </nvd-form-element>
                    <nvd-form-element field="others">
                        <input type="number" class="form-control" ng-model="form.others" placeholder="Enter others in Rs"/>
                    </nvd-form-element>
                    <button type="submit" class="btn btn-primary btn-flat">Create</button>
                </nvd-form>
            </uib-accordion-group>
        </uib-accordion>
    </div>
</div>