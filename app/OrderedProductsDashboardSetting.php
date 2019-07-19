<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderedProductsDashboardSetting extends Model
{
    public $guarded = ["ordered_p_id", "created_at", "updated_at"];
}
