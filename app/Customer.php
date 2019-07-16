<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table="customers";
    protected $primaryKey="customer_id";
    protected $guarded = ["customer_id", "created_at", "updated_at"];
    protected $hidden = ['remember_token'];
    public static $bulkEditableFields = ['shop_id', 'customer_type'];
//    public $appends = ['photo'];
//
//    public function getPhotoAttribute()
//    {
//        $publicPath = base_path('public');
//        $fileDir = '/assets/images/users/';
//        if (file_exists($publicPath . $fileDir . bcrypt($this->id) . ".jpg"))
//            return $fileDir . bcrypt($this->id) . ".jpg";
//        return $fileDir . "default.jpg";
//    }

    public static function findRequested()
    {
        $query = Customer::with(['shop']);

        // search results based on user input
        if (request('customer_id')) $query->where('customer_id', request('customer_id'));
        if (request('customer_name')) $query->where('customer_name', 'like', '%' . request('customer_name') . '%');
        if (request('customer_address')) $query->where('customer_address', 'like', '%' . request('customer_address') . '%');
        if (request('customer_phone')) $query->where('customer_phone', 'like', '%' . request('customer_phone') . '%');
        if (request('customer_email')) $query->where('customer_email', 'like', '%' . request('customer_email') . '%');
        if (request('created_at')) $query->where('created_at', request('created_at'));
        if (request('updated_at')) $query->where('updated_at', request('updated_at'));
        if (request('shop_id')) $query->where('shop_id', 'like', '%' . request('shop_id') . '%');
        if (request('customer_type')) $query->where('customer_type', request('customer_type'));

        // sort results
        if (request("sort")) $query->orderBy(request("sort"), request("sortType", "asc"));

        // paginate results
        if ($resPerPage = request("perPage"))
            return $query->paginate($resPerPage);
        return $query->get();
    }

    public function dashboardSettings()
    {
        $settings = CustomerDashboardSetting::where('customer_id', $this->id)->first();
        if ($settings) {
            return json_decode($settings->settings, true);
        }
        return null;
    }

    public function saveDashboardSettings($settings)
    {
        $settingsModel = CustomerDashboardSetting::where('customer_id', $this->id)->first();
        if (!$settingsModel) {
            $settingsModel = new CustomerDashboardSetting();
        }
        $settingsModel->settings = json_encode($settings);
        $settingsModel->customer_id = $this->id;
        return $settingsModel->save();
    }

    public static function validationRules($attributes = null)
    {
        $rules = [
            'customer_name' => 'required|string|max:191',
            'customer_address' => 'required|string|max:191',
            'customer_phone' => 'required',
            'customer_email' => 'required|email|unique:customers,customer_email',
            'shop_id' => 'required|integer',
            'customer_type' => 'required|in:Shopkeeper,Consumer'
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

    public function shop(){
        return $this->belongsTo(Shop::class,'shop_id','shop_id');
    }

}
