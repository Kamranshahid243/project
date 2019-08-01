<div class="row">
        <form class="search-form form-material">
            <div class="col-sm-4 col-md-4">
                <label>Quick Date Selector</label><br>
                <input type="radio" name="dateSelector" ng-change="updateDate()" ng-model="dateSelector"
                       value="thisMonth" selected><b>This Month</b>&nbsp;&nbsp;&nbsp;
                <input type="radio" name="dateSelector" ng-change="updateDate()" ng-model="dateSelector"
                       value="lastMonth"><b>Last Month</b>&nbsp;&nbsp;&nbsp;
                <input type="radio" name="dateSelector" ng-change="updateDate()" ng-model="dateSelector"
                       value="currentYear"><b>Current Year</b>
            </div>
            <div class="col-md-8">
                <table class="table table-bordered table-hover grid-view-tbl">
                    <tr class="search-row">

                        {{--<td>--}}
                            {{--<label>Shop</label>--}}
                            {{--<select class="form-control"--}}
                                    {{--ng-model="state.params.shop_id">--}}
                                {{--<option value="">Shop</option>--}}
                                {{--<option value="@{{ shop.shop_id }}" ng-repeat="shop in allShops"--}}
                                        {{--ng-show="shop.shop_status=='Active'">@{{ shop.shop_name }}--}}
                                {{--</option>--}}
                            {{--</select>--}}
                        {{--</td>--}}
                        <td>
                            <label>Start Date</label>
                            <input ng-model="startDate" class="form-control" moment-picker="start"
                                   format="YYYY-MM-DD" min-view="month" max-view="month">
                        </td>
                        <td>
                            <label>End Date</label>
                            <input ng-model="endDate" class="form-control"
                                   moment-picker="end" format="YYYY-MM-DD"></td>
                        <td style="padding-top: 33px">
                            <button class="btn btn-primary btn-flat" ng-click="showReport(startDate,endDate)">
                                Generate Report
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
</div>