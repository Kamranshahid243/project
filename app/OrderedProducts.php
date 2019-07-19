<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderedProducts extends Model
{
    protected $table = "ordered_products";
    protected $primaryKey = "ordered_p_id";
    protected $guarded = ["order_id", 'shop_id','product_id','product_quantity','total_price','freight','paid','remaining', "created_at", "updated_at"];
    protected $hidden = ['remember_token'];
    public static $bulkEditableFields = ['product_quantity', 'product_quantity','remaining'];

    public static function findRequested()
    {
        $query = OrderedProducts::with(['shop']);

        // search results based on user input
        if (request('ordered_p_id')) $query->where('ordered_p_id', request('ordered_p_id'));
        if (request('order_id')) $query->where('order_id', 'like', '%' . request('order_id') . '%');
        if (request('shop_id')) $query->where('shop_id', 'like', '%' . request('shop_id') . '%');
        if (request('product_id')) $query->where('product_id', 'like', '%' . request('product_id') . '%');
        if (request('product_quantity')) $query->where('product_quantity', 'like', '%' . request('product_quantity') . '%');
        if (request('total_price')) $query->where('total_price', 'like', '%' . request('total_price') . '%');
        if (request('freight')) $query->where('freight', 'like', '%' . request('freight') . '%');
        if (request('paid')) $query->where('paid', 'like', '%' . request('paid') . '%');
        if (request('remaining')) $query->where('remaining', 'like', '%' . request('remaining') . '%');
        if (request('status')) $query->where('status', 'like', '%' . request('status') . '%');
        // sort results
        if (request("sort")) $query->orderBy(request("sort"), request("sortType", "asc"));

        // paginate results
        if ($resPerPage = request("perPage"))
            return $query->paginate($resPerPage);
        return $query->get();
    }

    public function dashboardSettings()
    {
        $settings = OrderedProductsDashboardSetting::where('ordered_p_id', $this->id)->first();
        if ($settings) {
            return json_decode($settings->settings, true);
        }
        return null;
    }

    public function saveDashboardSettings($settings)
    {
        $settingsModel = OrderedProductsDashboardSetting::where('ordered_p_id', $this->id)->first();
        if (!$settingsModel) {
            $settingsModel = new OrderedProductsDashboardSetting();
        }
        $settingsModel->settings = json_encode($settings);
        $settingsModel->ordered_p_id = $this->id;
        return $settingsModel->save();
    }

    public static function validationRules($attributes = null)
    {
        $rules = [
            'order_id' => 'required|integer',
            'shop_id' => 'required|integer',
            'product_id' => 'required|integer',
            'product_quantity' => 'required|integer',
            'total_price' => 'required|integer',
            'freight' => 'required|integer',
            'paid' => 'required|integer',
            'remaining' => 'required|integer',
            'status' => 'required',

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
        return $this->belongsTo(Shop::class, 'shop_id', 'shop_id');
    }
}
