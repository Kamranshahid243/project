<!-- Modal -->
<script type="text/ng-template" id='addCustomers.html'>
    <div class=" modal-header">
        <h4 class="modal-title" id="myModalLabel">Add Customer</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="">Customer Name</label>
            <input type="text" class="form-control" ng-model="customer_name" placeholder="Customer Name"/>
        </div>
        <div class="form-group">
            <label for="">Customer Address</label>
            <input type="text" class="form-control" ng-model="customer_address" placeholder="Customer Address"/>
        </div>
        <div class="form-group">
            <label for="">Customer Email</label>
            <input type="email" class="form-control" ng-model="customer_email" placeholder="Customer Email"/>
        </div>
        <div class="form-group">
            <label for="">Customer phone</label>
            <input type="text" class="form-control" ng-model="customer_phone" placeholder="Customer Phone"/>
        </div>
        <div class="form-group">
            <select ng-options="item for item in ['Shopkeeper','Consumer']" class="form-control"
                    ng-model="customer_type">
                <option value="">--Customer type--</option>
            </select>
        </div>

        <div class="form-group">
            <select ng-options="item for item in ['Active','Inactive']" class="form-control"
                    ng-model="status">
                <option value="">--Customer status--</option>
            </select>
        </div>

        <a ng-click="add(customer_name,customer_address,customer_email,customer_phone,customer_type,status)"
           class="btn btn-primary btn-flat">Create Customer</a>
    </div>

</script>