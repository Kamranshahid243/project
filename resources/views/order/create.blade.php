<div class="row">
    <div class="col-md-6 col-sm-12">
        <uib-accordion>
            <uib-accordion-group panel-class="panel-default panel-flat">
                <uib-accordion-heading>
                    <i class="fa fa-plus"></i> Add a New Order
                </uib-accordion-heading>
                <nvd-form model="form" on-success="loadOrders()" action="/orders">
                    <nvd-form-element field="shop_id">
                        <select class="form-control" ng-model="form.shop_id">
                            <option value="">--Select Shop--</option>
                            <option ng-show="shop.shop_status=='Active'" value="@{{ shop.shop_id }}"
                                    ng-repeat="shop in allShops">@{{
                                shop.shop_name }}
                            </option>
                        </select>
                    </nvd-form-element>
                    <nvd-form-element field="customer_id">
                        <select class="form-control" ng-model="form.customer_id">
                            <option value="">Customer</option>
                            <option ng-show="customer.status=='Active' && customer.shop_id==form.shop_id" value="@{{ customer.customer_id }}" ng-repeat="customer in customers ">@{{
                                customer.customer_name }}</option>
                        </select>
                    </nvd-form-element>
                    {{--<nvd-form-element field="product_id">--}}
                        {{--<select class="form-control" ng-model="form.product_id[$index+1]">--}}
                            {{--<option value="">--Select Product--</option>--}}
                            {{--<option ng-repeat="product in allProducts" value="@{{ product.product_id }}"--}}
                                    {{--ng-show="product.product_status=='Active'">--}}
                                {{--@{{ product.product_name }}--}}
                            {{--</option>--}}
                        {{--</select>--}}
                    {{--</nvd-form-element>--}}

                    {{--<nvd-form-element field="available_quantity" ng-show="form.product_id[$index+1]">--}}
                        {{--<span>max</span>--}}
                        {{--<input type="number" min="1" max="@{{ product.available_quantity }}" class="form-control"--}}
                               {{--ng-model="form.available_quantity[$index+1]"--}}
                               {{--ng-init="form.available_quantity[$index+1]=product.available_quantity"--}}
                               {{--placeholder="Password" ng-repeat="product in allProducts"/>--}}
                    {{--</nvd-form-element>--}}

                    <section >
                        <div class="row">
                            <div class="col-md-6">
                                <nvd-form-element class="form-group" field="product_id">
                                    <select class="form-control" name="product_id[]" ng-model="form.product_id[$index+1]">
                                        <option value="">--Select Product--</option>
                                        <option ng-repeat="product in allProducts" value="@{{ product.product_id }}"
                                                ng-show="product.product_status=='Active'">
                                            @{{ product.product_name }}
                                        </option>
                                    </select>
                                </nvd-form-element>
                            </div>
                            <div class="col-md-5">
                                <nvd-form-element field="available_quantity" class="form-group">
                                    <input type="number" min="1" max="@{{ product.available_quantity }}" name="available_quantity[]"
                                           class="form-control"
                                           ng-model="form.available_quantity[$index+1]"
                                           ng-init="form.available_quantity[$index+1]=product.available_quantity"
                                           placeholder="Password" ng-repeat="product in allProducts"/>
                                </nvd-form-element>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <a ng-click="removeOrder(field)" ng-if="$index!=0"
                                       style="color:red; cursor: pointer;"><sub>X</sub></a>
                                </div>
                            </div>
                        </div>
                    </section>

                    <nvd-form-element field="password">
                        <input type="password" class="form-control" ng-model="form.password" placeholder="Password"/>
                    </nvd-form-element>

                    <nvd-form-element field="status">
                        <select ng-options="item for item in ['Enabled','Disabled']" class="form-control"
                                ng-model="form.status">
                            <option value="">Status</option>
                        </select>
                    </nvd-form-element>

                    <nvd-form-element field="user_role_id">
                        <remote-select
                                url="/user-role"
                                ng-model="form.user_role_id"
                                label-field="role" value-field="id"
                                placeholder="User Role"
                        ></remote-select>
                    </nvd-form-element>

                    <button type="submit" class="btn btn-primary btn-flat">Create</button>
                </nvd-form>
            </uib-accordion-group>
        </uib-accordion>
    </div>
</div>