<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UserDashboardSetting *
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $settings
 * @property integer $created_at
 * @property integer $updated_at
 * @mixin \Eloquent
 */
class UserDashboardSetting extends Model
{

    public $guarded = ["id", "created_at", "updated_at"];

}
