<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseDashboardSettings extends Model
{
    public $guarded = ["expense_id", "created_at", "updated_at"];

}
