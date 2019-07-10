<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $status
 * @property int $user_role_id
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \App\UserRole $role
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUserRoleId($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;
    
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $hidden = ['password', 'remember_token'];
    public static $bulkEditableFields = ['status', 'user_role_id'];
    public $appends = ['photo'];

    public function getPhotoAttribute()
    {
        $publicPath = base_path('public');
        $fileDir = '/assets/images/users/';
        if (file_exists($publicPath . $fileDir . bcrypt($this->id) . ".jpg"))
            return $fileDir . bcrypt($this->id) . ".jpg";
        return $fileDir . "default.jpg";
    }

    public static function findRequested()
    {
        $query = User::query();

        // search results based on user input 
        if (request('id')) $query->where('id', request('id'));
        if (request('name')) $query->where('name', 'like', '%' . request('name') . '%');
        if (request('email')) $query->where('email', 'like', '%' . request('email') . '%');
        if (request('created_at')) $query->where('created_at', request('created_at'));
        if (request('updated_at')) $query->where('updated_at', request('updated_at'));
        if (request('status')) $query->where('status', 'like', '%' . request('status') . '%');
        if (request('user_role_id')) $query->where('user_role_id', request('user_role_id'));

        // sort results 
        if (request("sort")) $query->orderBy(request("sort"), request("sortType", "asc"));

        // paginate results 
        if ($resPerPage = request("perPage"))
            return $query->paginate($resPerPage);
        return $query->get();
    }

    public function dashboardSettings()
    {
        $settings = UserDashboardSetting::where('user_id', $this->id)->first();
        if ($settings) {
            return json_decode($settings->settings, true);
        }
        return null;
    }

    public function saveDashboardSettings($settings)
    {
        $settingsModel = UserDashboardSetting::where('user_id', $this->id)->first();
        if (!$settingsModel) {
            $settingsModel = new UserDashboardSetting();
        }
        $settingsModel->settings = json_encode($settings);
        $settingsModel->user_id = $this->id;
        return $settingsModel->save();
    }

    public static function validationRules($attributes = null)
    {
        $rules = [
            'name' => 'required|string|max:191',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'status' => 'required|in:Enabled,Disabled',
            'user_role_id' => 'required|integer',
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
    
    public function role()
    {
        return $this->hasOne(UserRole::class, 'id', 'user_role_id');
    }

    public function isSuperAdmin()
    {
        return $this->user_role_id == 1;
    }
}
