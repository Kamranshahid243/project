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
                        <input class="form-control" ng-model="form.shop_address" placeholder="Email"/>
                    </nvd-form-element>

                    <nvd-form-element field="shop_type">
                        <select ng-options="item for item in ['Wholesale','Retail']" class="form-control"
                                ng-model="form.shop_type">
                            <option value="">Shop Type</option>
                        </select>
                    </nvd-form-element>

                    <nvd-form-element field="printer_type">
                        <select ng-options="item for item in ['Wholesale','Retail']" class="form-control"
                                ng-model="form.shop_type">
                            <option value="">Shop Type</option>
                        </select>
                    </nvd-form-element>
                    {{--<nvd-form-element field="printer_type">--}}
                        {{--<remote-select--}}
                                {{--url="/printer-type"--}}
                                {{--ng-model="form.printer_type"--}}
                                {{--label-field="role" value-field="id"--}}
                                {{--placeholder="Printer Type"--}}
                        {{--></remote-select>--}}
                    {{--</nvd-form-element>--}}

                    <button type="submit" class="btn btn-primary btn-flat">Create</button>
                </nvd-form>
            </uib-accordion-group>
        </uib-accordion>
    </div>
</div>