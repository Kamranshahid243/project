<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $guarded = ["shop_id", "created_at", "updated_at"];
    public static $bulkEditableFields = ['shop_name', 'shop_address','shop_type','printer_type'];

    public static function findRequested()
    {
        $query = Shop::query();

        // search results based on user input
        if (request('shop_id')) $query->where('shop_id', request('shop_id'));
        if (request('shop_name')) $query->where('shop_name', 'like', '%' . request('shop_name') . '%');
        if (request('shop_address')) $query->where('shop_address', 'like', '%' . request('shop_address') . '%');
        if (request('created_at')) $query->where('created_at', request('created_at'));
        if (request('updated_at')) $query->where('updated_at', request('updated_at'));
        if (request('shop_type')) $query->where('shop_type', 'like', '%' . request('shop_type') . '%');
        if (request('printer_type')) $query->where('printer_type', request('printer_type'));

        // sort results
        if (request("sort")) $query->orderBy(request("sort"), request("sortType", "asc"));

        // paginate results
        if ($resPerPage = request("perPage"))
            return $query->paginate($resPerPage);
        return $query->get();
    }

    public function dashboardSettings()
    {
        $settings =ShopDashboardSetting::where('shop_id', $this->id)->first();
        if ($settings) {
            return json_decode($settings->settings, true);
        }
        return null;
    }

    public function saveDashboardSettings($settings)
    {
        $settingsModel = ShopDashboardSetting::where('shop_id', $this->id)->first();
        if (!$settingsModel) {
            $settingsModel = new ShopDashboardSetting();
        }
        $settingsModel->settings = json_encode($settings);
        $settingsModel->shop_id = $this->id;
        return $settingsModel->save();
    }

    public static function validationRules($attributes = null)
    {
        $rules = [
            'shop_name' => 'required|string|max:191',
            'shop_address' => 'required|string|max:191',
            'shop_type' => 'required|in:Wholesale,Retail',
            'printer_type' => 'required|in:Thermal,Laser',
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



}
