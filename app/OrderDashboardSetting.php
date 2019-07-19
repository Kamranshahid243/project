<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDashboardSetting extends Model
{
    public $guarded = ["order_id", "created_at", "updated_at"];}
