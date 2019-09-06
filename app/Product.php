<?php

namespace App;

use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Database\Eloquent\Model;
use Nvd\Crud\Db;
use PhpParser\Builder;

class  Product extends Model
{
    protected $primaryKey = 'product_id';
    protected $appends =['tqty','tprice'];
    public $fillable = ['product_id', 'shop_id', 'product_name', 'product_code', 'product_category', 'product_description', 'available_quantity', 'unit_price', 'product_status','purchase_id'];
    public static $bulkEditableFields = ['available_quantity', 'unit_price'];
    public function getTpriceAttribute() {
        return ($this->unit_price - $this->purchase['purchase_cost']) * $this->getTqtyAttribute();
    }
    public function getTqtyAttribute() {
        return $this->productOrder->sum('qty');
    }
    public static function validationRules($attributes = null)
    {
        $rules = [
            'shop_id' => 'required',
            'product_name' => 'required',
            'product_code' => 'required',
            'product_category' => 'required',
            'product_description' => 'required',
            'available_quantity' => 'required',
            'unit_price' => 'required',
            'product_status' => 'nullable',
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


    public static function findRequested()
    {
        $query = Product::with(['category','productOrder','purchase']);
//         search results based on user input
        if ($categoryName = request('category_name')) {
            $query->whereHas('category', function ($item) use ($categoryName) {
                $item->where('category_name', "like", "%{$categoryName}%");
            });
        }
        if (request('product_name')) $query->where('product_name', 'like', "%" . request('product_name') . "%");
        if (request('product_code')) $query->where('product_code', 'like', '%' . request('product_code') . '%');
        if (request('product_description')) $query->where('product_description', 'like', '%' . request('product_description') . '%');
        if (request('created_at')) $query->where('created_at', request('created_at'));
        if (request('updated_at')) $query->where('updated_at', request('updated_at'));
        if (request('available_quantity')) $query->where('available_quantity', 'like', '%' . request('available_quantity') . '%');
        if (request('unit_price')) $query->where('unit_price', 'like', '%' . request('unit_price') . '%');
        // sort results
        if (request("sort")) $query->orderBy(request("sort"), request("sortType", "asc"));

        // paginate results
        if (request("perPage"))
            return $query->paginate(request('perPage'));

        return $query->get();
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::Class, 'product_category', 'id');
    }

    public function productOrder()
    {
        return $this->hasMany(Order::class, 'product_id', 'product_id');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class,'purchase_id','id');
    }
}