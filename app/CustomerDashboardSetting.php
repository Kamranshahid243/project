<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerDashboardSetting extends Model
{
    public $guarded = ["customer_id", "created_at", "updated_at"];
}
