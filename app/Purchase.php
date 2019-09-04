<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['shop_id','v_cat_id', 'vendor_id', 'product_name', 'quantity', 'original_cost', 'purchase_cost', 'customer_cost', 'paid','payable','total','date',];
    public static $bulkEditableFields = ['quantity', 'unit_price'];

    public static function validationRules($attributes = null)
    {
        $rules = [
            'vendor_id' => 'required|integer',
            'product_name' => 'required|string',
            'product_code' => 'required|string',
            'category_id' => 'required|string',
            'product_description' => 'required|string',
            'quantity' => 'required|integer',
            'original_cost' => 'required|integer',
            'purchase_cost' => 'required|integer',
            'customer_cost' => 'required|integer',
            'paid' => 'required|integer',
            'product_status' => 'required',
            'date' => 'required',
        ];


        // no list is provided
        if (!$attributes)
            return $rules;

        // a single attribute is provided
        if (!is_array($attributes))
            return [$attributes => $rules[$attributes]];

        // a list of attributes is provided
        $newRules = [];
        foreach ($attributes as $attr)
            $newRules[$attr] = $rules[$attr];
        return $newRules;
    }


    public static function findRequested()
    {
        $query = Purchase::where('shop_id', session('shop')->shop_id)->with(['Shop','vendor','vendorCategory']);
        // search results based on user input
        if (request('vendor_id')) $query->where('vendor_id', 'like', "%" . request('vendor_id') . "%");
        if (request('startDate')) $query->where('date', '>=', request('startDate') . "%");
        if (request('endDate')) $query->where('date', '<=', request('endDate') . "%");
        if (request('id')) $query->where('vendor_id', 'like', "%" . request('id') . "%");
        if (request('product_name')) $query->where('product_name', 'like', "%" . request('product_name') . "%");
        if (request('quantity')) $query->where('quantity', 'like', "%" . request('quantity') . "%");
        if (request('original_cost')) $query->where('original_cost', 'like', "%" . request('original_cost') . "%");
        if (request('purchase_cost')) $query->where('purchase_cost', 'like', "%" . request('purchase_cost') . "%");
        if (request('customer_cost')) $query->where('customer_cost', 'like', "%" . request('customer_cost') . "%");
        if (request('paid')) $query->where('paid', 'like', '%' . request('paid') . '%');
        if (request('payable')) $query->where('payable', 'like', '%' . request('payable') . '%');
        if (request('created_at')) $query->where('created_at', request('created_at'));
        if (request('updated_at')) $query->where('updated_at', request('updated_at'));
        if (request('date')) $query->where('date', 'like', '%' . request('date') . '%');

        // sort results
        if (request("sort")) $query->orderBy(request("sort"), request("sortType", "asc"));

        // paginate results
        if ($resPerPage = request("perPage"))
            return $query->paginate($resPerPage);
        return $query->get();
    }

    public function Shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'shop_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'vendor_id');
    }

    public function vendorCategory()
    {
        return $this->belongsTo(VendorCategory::class, 'vendor_id');
    }
}
