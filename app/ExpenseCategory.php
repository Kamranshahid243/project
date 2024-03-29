<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    protected $guarded = ["id", "created_at", "updated_at"];
    public static $bulkEditableFields = ['cat_name','status'];

    public static function findRequested()
    {
        $query = ExpenseCategory::query();

        // search results based on user input
        if (request('id')) $query->where('id', 'like', '%' . request('id') . '%');
        if (request('cat_name')) $query->where('cat_name', 'like', '%' . request('cat_name') . '%');
        if (request('created_at')) $query->where('created_at', request('created_at'));
        if (request('updated_at')) $query->where('updated_at', request('updated_at'));
        if (request('status')) $query->where('status', '=', request('status'));
        // sort results
        if (request("sort")) $query->orderBy(request("sort"), request("sortType", "asc"));

        // paginate results
        if ($resPerPage = request("perPage"))
            return $query->paginate($resPerPage);
        return $query->get();
    }

    public function dashboardSettings()
    {
        $settings = ExpenseCategoryDashboardSettings::where('id', $this->id)->first();
        if ($settings) {
            return json_decode($settings->settings, true);
        }
        return null;
    }

    public function saveDashboardSettings($settings)
    {
        $settingsModel = ExpenseCategoryDashboardSettings::where('id', $this->id)->first();
        if (!$settingsModel) {
            $settingsModel = new ExpenseCategoryDashboardSettings();
        }
        $settingsModel->settings = json_encode($settings);
        $settingsModel->id = $this->id;
        return $settingsModel->save();
    }

    public static function validationRules($attributes = null)
    {
        $rules = [
            'cat_name' => 'required|string',
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

    public function expense()
    {
        return $this->hasOne(Expense::class);
    }

}
