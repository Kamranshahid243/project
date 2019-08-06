<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public $fillable = ['customer_id', 'date'];

    public function Customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function Order()
    {
        return $this->hasMany(Order::class, 'bill_id');
    }

    public static function validationRules($attributes = null)
    {
        $rules = [
            'customer' => 'required',
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
