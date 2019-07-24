<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $primaryKey = "expense_id";
    protected $guarded = ["expense_id", "created_at", "updated_at"];
    public static $bulkEditableFields = ['shop_id','rent', 'salaries', 'refreshment', 'drawing', 'loss','bills','others'];

    public static function findRequested()
    {
        $query = Expense::query();

        // search results based on user input
        if (request('shop_id')) $query->where('shop_id', request('shop_id'));
        if (request('expense_id')) $query->where('expense_id', 'like', '%' . request('expense_id') . '%');
        if (request('rent')) $query->where('rent', 'like', '%' . request('rent') . '%');
        if (request('created_at')) $query->where('created_at', request('created_at'));
        if (request('updated_at')) $query->where('updated_at', request('updated_at'));
        if (request('salaries')) $query->where('salaries', 'like', '%' . request('salaries') . '%');
        if (request('refreshment')) $query->where('refreshment', request('refreshment'));
        if (request('drawing')) $query->where('drawing', request('drawing'));
        if (request('loss')) $query->where('loss', request('loss'));
        if (request('bills')) $query->where('bills', request('bills'));
        if (request('others')) $query->where('others', request('others'));
        // sort results
        if (request("sort")) $query->orderBy(request("sort"), request("sortType", "asc"));

        // paginate results
        if ($resPerPage = request("perPage"))
            return $query->paginate($resPerPage);
        return $query->get();
    }

    public function dashboardSettings()
    {
        $settings = ExpenseDashboardSettings::where('expense_id', $this->id)->first();
        if ($settings) {
            return json_decode($settings->settings, true);
        }
        return null;
    }

    public function saveDashboardSettings($settings)
    {
        $settingsModel = ExpenseDashboardSettings::where('expense_id', $this->id)->first();
        if (!$settingsModel) {
            $settingsModel = new ExpenseDashboardSettings();
        }
        $settingsModel->settings = json_encode($settings);
        $settingsModel->expense_id = $this->id;
        return $settingsModel->save();
    }

    public static function validationRules($attributes = null)
    {
        $rules = [
            'shop_id' => 'required',

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
        return $this->hasMany(Shop::class, 'shop_id');
    }

}
