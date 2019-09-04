<div class="row">
    <form class="search-form form-material">
        <div class="col-sm-5 col-md-5">
            <label>Quick Date Selector</label><br>
            <input type="radio" name="dateSelector" ng-change="updateDate()" ng-model="dateSelector"
                   value="thisMonth" id="thisMonth"><label for="thisMonth">This Month</label>&nbsp;&nbsp;&nbsp;
            <input type="radio" name="dateSelector" ng-change="updateDate()" ng-model="dateSelector"
                   value="lastMonth" id="lastMonth"><label for="lastMonth">Last Month</label>&nbsp;&nbsp;&nbsp;
            <input type="radio" name="dateSelector" ng-change="updateDate()" ng-model="dateSelector"
                   value="currentYear" id="currentYear"><label for="currentYear">Current Year</label>
        </div>
        <div class="col-md-7 date-search">
            <table class="table table-bordered table-hover grid-view-tbl">
                <tr class="search-row">
                    <td>
                        <label>Start Date</label>
                        <input ng-model="startDate" class="form-control" moment-picker="start"
                               format="YYYY-MM-DD" min-view="month" max-view="month">
                    </td>
                    <td>
                        <label>End Date</label>
                        <input ng-model="endDate" class="form-control"
                               moment-picker="end" format="YYYY-MM-DD"></td>
                    <td style="padding-top: 32px;">
                        <button class="btn btn-primary btn-flat" ng-click="VendorStockReport(startDate,endDate)">
                            Generate Report
                        </button>
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>