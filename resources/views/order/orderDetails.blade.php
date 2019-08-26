<!-- Modal -->
<script type="text/ng-template" id='orderDetails.html'>
    <div class=" modal-header">
        <h4 class="modal-title" id="myModalLabel">Bill Record</h4>
    </div>
    {{--<pre>@{{ billDetails | json }}</pre>/--}}
    <div class="modal-body">
        <table class="table table-striped">
            <tr>
                <th>Product Name</th>
                <th>Item Sold</th>
                <th>Price</th>
            </tr>
            <tr ng-repeat="item in billDetails.order">
                <td>@{{ item.product.product_name }}</td>
                <td>@{{ item.qty }}</td>
                <td>@{{ item.product.unit_price }}</td>
            </tr>
        </table></div>

</script>