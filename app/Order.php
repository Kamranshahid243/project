<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
//

    protected $table = "orders";
    protected $primaryKey = "order_id";
    protected $guarded = ["shop_type", 'shop_id', "created_at", "updated_at"];
    protected $hidden = ['remember_token'];
    public static $bulkEditableFields = ['shop_id', 'customer_type'];

    public static function findRequested()
    {
        $query = Order::with(['shop']);

        // search results based on user input
        if (request('customer_id')) $query->where('customer_id', request('customer_id'));
        if (request('order_id')) $query->where('order_id', 'like', '%' . request('order_id') . '%');
        if (request('shop_id')) $query->where('shop_id', 'like', '%' . request('shop_id') . '%');
        if (request('shop_type')) $query->where('shop_type', 'like', '%' . request('shop_type') . '%');

        // sort results
        if (request("sort")) $query->orderBy(request("sort"), request("sortType", "asc"));

        // paginate results
        if ($resPerPage = request("perPage"))
            return $query->paginate($resPerPage);
        return $query->get();
    }

    public function dashboardSettings()
    {
        $settings = OrderDashboardSetting::where('order_id', $this->id)->first();
        if ($settings) {
            return json_decode($settings->settings, true);
        }
        return null;
    }

    public function saveDashboardSettings($settings)
    {
        $settingsModel = OrderDashboardSetting::where('order_id', $this->id)->first();
        if (!$settingsModel) {
            $settingsModel = new OrderDashboardSetting();
        }
        $settingsModel->settings = json_encode($settings);
        $settingsModel->order_id = $this->id;
        return $settingsModel->save();
    }

    public static function validationRules($attributes = null)
    {
        $rules = [
            'customer_name' => 'required|string|max:191',
            'shop_type' => 'required',
            'customer_phone' => 'required',
            'customer_email' => 'required|email|unique:customers,customer_email',
            'shop_id' => 'required|integer',
            'customer_type' => 'required|in:Shopkeeper,Consumer',
            'shop_type' => 'required',
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

//    public function shop()
//    {
//        return $this->belongsTo(Shop::class, 'shop_id', 'shop_id');
//    }

    public function shop()
    {
        return $this->belongsTo(Shop::class,'shop_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
