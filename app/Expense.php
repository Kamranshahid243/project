<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $guarded = ["id", "created_at", "updated_at"];
    public static $bulkEditableFields = ['shop_id', 'category_id', 'cost', 'date'];
//    public $appends=['total'];
//
//    public function getTotalAttribute()
//    {
//        return $this->shop;
//    }
    public static function findRequested()
    {
        $query = Expense::with('expenseCategory');

        // search results based on user input
        if (request('shop_id')) $query->where('shop_id', request('shop_id'));
        if (request('id')) $query->where('id', 'like', '%' . request('id') . '%');
        if (request('category_id')) $query->where('category_id', 'like', '%' . request('category_id') . '%');
        if (request('created_at')) $query->where('created_at', request('created_at'));
        if (request('updated_at')) $query->where('updated_at', request('updated_at'));
        if (request('cost')) $query->where('cost', 'like', '%' . request('cost') . '%');
        if (request('date')) $query->where('date', request('date'));
        // sort results
        if (request("sort")) $query->orderBy(request("sort"), request("sortType", "asc"));

        // paginate results
        if ($resPerPage = request("perPage"))
            return $query->paginate($resPerPage);
        return $query->get();
    }

    public function dashboardSettings()
    {
        $settings = ExpenseDashboardSettings::where('id', $this->id)->first();
        if ($settings) {
            return json_decode($settings->settings, true);
        }
        return null;
    }

    public function saveDashboardSettings($settings)
    {
        $settingsModel = ExpenseDashboardSettings::where('id', $this->id)->first();
        if (!$settingsModel) {
            $settingsModel = new ExpenseDashboardSettings();
        }
        $settingsModel->settings = json_encode($settings);
        $settingsModel->id = $this->id;
        return $settingsModel->save();
    }

    public static function validationRules($attributes = null)
    {
        $rules = [
            'category_id' => 'required|integer',
            'cost' => 'required|integer',
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

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'shop_id');
    }

    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }
}