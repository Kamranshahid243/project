<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $fillable = ['product_id', 'shop_id', 'product_name', 'product_code', 'product_description', 'available_quantity', 'unit_price'];

    public static function validationRules($attributes = null)
    {
        $rules = [
            'shop_id' => 'required',
            'product_name' => 'required',
            'product_code' => 'required',
            'product_description' => 'required',
            'available_quantity' => 'required',
            'unit_price' => 'required',
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