<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserRole
 *
 * @property integer $id
 * @property integer $role
 * @property integer $default_read_access
 * @property integer $default_cud_access
 * @property integer $created_at
 * @property integer $updated_at
 * @method static \Illuminate\Database\Query\Builder|UserRole whereId($value)
 * @method static \Illuminate\Database\Query\Builder|UserRole whereRole($value)
 * @method static \Illuminate\Database\Query\Builder|UserRole whereDefaultReadAccess($value)
 * @method static \Illuminate\Database\Query\Builder|UserRole whereDefaultCudAccess($value)
 * @method static \Illuminate\Database\Query\Builder|UserRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|UserRole whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PageAction[] $pageActions
 * @mixin \Eloquent
 */
class UserRole extends Model {
    public $guarded = ["id","created_at","updated_at"];

    public function pageActions()
    {
        return $this->belongsToMany(PageAction::class, 'user_role_page_action')->withTimestamps();
    }

    /**
     * @param $route \Illuminate\Routing\Route
     * @return bool
     */
    public function canAccess($route)
    {
        $path = $route->uri();
        $method = array_get($route->methods(), 0);

        // check if a rule exists in the DB
        $ruleInTheDB = PageAction::where('route', $path)->where('method', $method)->first();
        if ($ruleInTheDB) {
            // rule exists, check if the role is granted access
            $roleAction = $this->pageActions()->wherePivot('page_action_id', $ruleInTheDB->id)->first();
            if ($roleAction)
                return true;
            return false;
        }

        // no rule exists, check default access for the given http method
        if ($method == 'GET' && $this->default_read_access != 'Granted')
            return false;
        elseif ($this->default_cud_access != 'Granted')
            return false;

        return true;
    }

    public static function findRequested()
    {
        $query = UserRole::query()->with('pageActions');

        // search results based on user input
        if(request('id')) $query->where('id', request('id'));
        if(request('role')) $query->where('role', 'like', '%'.request('role').'%');
        if(request('default_read_access')) $query->where('default_read_access', 'like', '%'.request('default_read_access').'%');
        if(request('default_cud_access')) $query->where('default_cud_access', 'like', '%'.request('default_cud_access').'%');
        if(request('created_at')) $query->where('created_at', request('created_at'));
        if(request('updated_at')) $query->where('updated_at', request('updated_at'));
        
        // sort results
        if(request("sort")) $query->orderBy(request("sort"), request("sortType", "asc"));

        // paginate results
        if( $resPerPage = request("perPage") )
            return $query->paginate($resPerPage);
        return $query->get();
    }

    public static function validationRules( $attributes = null )
    {
        $rules = [
            'role' => 'required|string|max:191',
            'default_read_access' => 'required|in:Granted,Declined',
            'default_cud_access' => 'required|in:Granted,Declined',
        ];

        // no list is provided
        if(!$attributes)
            return $rules;

        // a single attribute is provided
        if(!is_array($attributes))
            return [ $attributes => $rules[$attributes] ];

        // a list of attributes is provided
        $newRules = [];
        foreach ( $attributes as $attr )
            $newRules[$attr] = $rules[$attr];
        return $newRules;
    }

    public function widgets()
    {
        return $this->belongsToMany(Widget::class, 'user_role_widgets')->withTimestamps();
    }
}
