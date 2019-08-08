<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
//

    protected $table = "orders";
    protected $fillable = ['shop_type', 'shop_id', 'customer_id', 'product_id', 'product_category', 'bill_id', 'order_status', 'price', 'payable', 'qty', 'order_status', "created_at", "updated_at", 'date'];


    public static function findRequested()
    {
        $query = Order::with(['shop', 'customer']);


        // search results based on user input
        if (request('customer_id')) $query->where('customer_id', request('customer_id'));
        if (request('order_id')) $query->where('order_id', 'like', ' % ' . request('order_id') . ' % ');
        if (request('shop_id')) $query->where('shop_id', 'like', ' % ' . request('shop_id') . ' % ');
        if (request('shop_type')) $query->where('shop_type', 'like', ' % ' . request('shop_type') . ' % ');

        if ($customerName = request('customer_name')) {
            $query->whereHas('customer', function ($item) use ($customerName) {
                $item->where('customer_name', "like", "%{$customerName}%");
            });
        }

        // sort results
//        if (request("sort")) $query->orderBy(request("sort"), request("sortType", "asc"));

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
            'customer_name' => 'required | string | max:191',
            'customer_id' => 'required',
            'shop_type' => 'required',
            'product_category' => 'required',
            'customer_phone' => 'required',
            'customer_email' => 'required | email | unique:customers,customer_email',
            'shop_id' => 'required | integer',
            'customer_type' => 'required | in:Shopkeeper,Consumer',
            'paid' => 'required',
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

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class,'product_category');
    }
}
