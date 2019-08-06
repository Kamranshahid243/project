<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    public $fillable = ['vendor_id','v_cat_id', 'shop_id', 'vendor_name', 'vendor_address', 'vendor_phone', 'vendor_email', 'vendor_status'];
    public static $bulkEditableFields = ['vendor_name', 'vendor_status'];

    public static function validationRules($attributes = null)
    {
        $rules = [
            'v_cat_id' => 'required',
            'vendor_name' => 'required',
            'vendor_address' => 'required',
            'vendor_phone' => 'required',
            'vendor_email' => 'required|email',
            'vendor_status' => 'required',
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
        $query = Vendor::with('vendorCategory')->where('shop_id','=',session('shop')->shop_id)->with('shop');

//         search results based on user input
        if (request('shop_id')) $query->where('shop_id', request('shop_id'));
        if (request('vendor_name')) $query->where('vendor_name', 'like', '%' . request('vendor_name') . '%');
        if (request('vendor_address')) $query->where('vendor_address', 'like', '%' . request('vendor_address') . '%');
        if (request('created_at')) $query->where('created_at', request('created_at'));
        if (request('updated_at')) $query->where('updated_at', request('updated_at'));
        if (request('vendor_phone')) $query->where('vendor_phone', 'like', '%' . request('vendor_phone') . '%');
        if (request('vendor_email')) $query->where('vendor_email', 'like', '%' . request('vendor_email') . '%');
        if (request('vendor_status')) $query->where('vendor_status', request('vendor_status'));

        // sort results
        if (request("sort")) $query->orderBy(request("sort"), request("sortType", "asc"));

        // paginate results
        if ($resPerPage = request("perPage"))
            return $query->paginate($resPerPage);
        return $query->get();
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class,'shop_id');
    }

    public function vendorCategory()
    {
        return $this->hasOne(VendorCategory::class,'id','v_cat_id');
    }

}

