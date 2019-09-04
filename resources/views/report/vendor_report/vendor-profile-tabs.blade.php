<div class="col-md-9" show-loader="state.loadingVendorsReport">
    @include('report.vendor_report.vendor-report-generater')
    <div class="nav-tabs-custom">
        <div class="row">
            <div class="col-sm-12" ng-show="vendorsReport">
                <div class="box">
                    <div class="box-body">
                        <table class="table table-bordered grid-view-tbl">
                            <thead>
                            <tr class="header-row">
                                <th>
                                    <filter-btn
                                            field-name="product_name"
                                            field-label="Product"
                                            search-field='true'
                                            model="state.params"
                                    ></filter-btn>
                                </th>
                                <th>
                                    <filter-btn
                                            field-name="quantity"
                                            field-label="Quantity"
                                            model="state.params"
                                    ></filter-btn>
                                </th>
                                <th>
                                    <filter-btn
                                            field-name="paid"
                                            field-label="Paid"
                                            model="state.params"
                                    ></filter-btn>
                                </th>
                                <th>
                                    <filter-btn
                                            field-name="payable"
                                            field-label="Payable"
                                            model="state.params"
                                    ></filter-btn>
                                </th>
                                <th>
                                    <filter-btn
                                            field-name="total"
                                            field-label="Total"
                                            model="state.params"
                                    ></filter-btn>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="report in vendorsReport">
                                <td>
                                    @{{ report.product_name }}
                                </td>

                                <td>
                                    @{{ report.quantity + ' Pcs' }}
                                </td>
                                <td>
                                    @{{ report.paid| currency:'PKR ' }}
                                </td>
                                <td>
                                    @{{ report.payable| currency:'PKR ' }}
                                </td>
                                <td>
                                    @{{ report.total| currency:'PKR ' }}
                                </td>
                            </tr>

                            <tr class="alert alert-warning"
                                >
                                <td ng-if="!vendorsReport.length && !state.loadingVendorsReport" colspan="8">No records found.</td>
                            </tr>
                            </tbody>
                        </table>
                        <hr>
                        <pagination state="state" records-info="recordsInfo"></pagination>
                    </div>
                </div>
            </div>
            <toaster-container></toaster-container>
        </div>
    </div>
</div>