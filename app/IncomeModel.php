<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncomeModel extends Model
{
    public $fillable = ['product_name', 'price', 'date'];

    public static function findRequested()
    {
        $query = IncomeModel::query();
        return $query->get();
    }
}
