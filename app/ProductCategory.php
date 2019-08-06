<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    public $fillable = ['category_name', 'status', 'shop_id'];

    public static function findRequested()
    {
        $query = ProductCategory::where('shop_id', '=', session('shop')->shop_id);

        // search results based on user input
        if (request('id')) $query->where('id', 'like', '%' . request('id') . '%');
        if (request('category_name')) $query->where('category_name', 'like', '%' . request('category_name') . '%');
        if (request('created_at')) $query->where('created_at', request('created_at'));
        if (request('updated_at')) $query->where('updated_at', request('updated_at'));
        if (request('status')) $query->where('status', '=', request('status'));
        if (request('shop_id')) $query->where('shop_id', '=', request('shop_id'));
        // sort results
        if (request("sort")) $query->orderBy(request("sort"), request("sortType", "asc"));
        return $query->get();
    }

    public static function validationRules($attributes = null)
    {
        $rules = [
            'category_name' => 'required|string',
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

}
