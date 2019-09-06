<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
//    public $fillable = ['customer_id', 'paid', 'shop_id', 'date'];
    protected $guarded = ['id', 'created_at', 'updated_at'];
    public $appends = ['total'];

    public function getTotalAttribute()
    {
        return $this->order->sum('price');
    }

    public static function findRequested()
    {
        $query = Bill::with(['customer', 'order.product', 'product']);

        if ($customerName = \request('name')) {
            $query->whereHas('customer', function ($item) use ($customerName) {
                $item->where('customer_name', 'like', "%{$customerName}%");
            });
        }

        // paginate results
        if ($resPerPage = request("perPage"))
            return $query->paginate($resPerPage);

        return $query->get();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function order()
    {

        return $this->hasMany(Order::class, 'bill_id');
    }

    public static function validationRules($attributes = null)
    {
        $rules = [
            'customer' => 'required',
            'paid' => 'required',
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
