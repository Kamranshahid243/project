<?php
namespace App\Http\Controllers;

use App\UserRole;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public $viewDir = "user_role";

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return UserRole::findRequested();
        }
        return $this->view("index");
    }

    public function saveRoleActions(Request $request)
    {
        if (!$request->role)
            abort(403, "Invalid data. No role specified.");
        $role = UserRole::find($request->role);
        /* @var $role UserRole */
        if (!$role)
            abort(404, "User Role not found.");

        // get action ids that need to be attached | detached
        $attachedList = collect([]);
        foreach ($request->pages as $page) {
            $checked = collect($page['children'])
                ->filter(function ($node) {
                    return $node['checked'];
                })->pluck('id')->all();
            $attachedList = $attachedList->merge($checked);
        }
        $role->pageActions()->sync($attachedList->all());

        return $role->pageActions;
    }

    public function store(Request $request)
    {
        $this->validate($request, UserRole::validationRules());
        return UserRole::create($request->all());
    }

    public function update(Request $request, UserRole $userRole)
    {
        if( $request->wantsJson() )
        {
            $data = [$request->name  => $request->value];
            $validator = \Validator::make( $data, UserRole::validationRules( $request->name ) );
            if($validator->fails())
                return response($validator->errors()->first( $request->name),403);
            $userRole->update($data);
            return "UserRole updated.";
        }

        $this->validate($request, UserRole::validationRules());
        $userRole->update($request->all());
        return redirect('/user-role');
    }

    public function destroy(Request $request, UserRole $userRole)
    {
        $userRole->delete();
        return "User Role deleted";
    }

    public function bulkDelete(Request $request)
    {
        $items = $request->items;
        if(!$items) {
            abort(403, "Please select some items.");
        }

        if(!$ids = collect($items)->pluck('id')->all()) {
            abort(403, "No ids provided.");
        }

        UserRole::whereIn('id', $ids)->delete();
        return response("Deleted");
    }

    public function bulkEdit(Request $request)
    {
        if (!$field = $request->field) {
            abort(403, "Invalid request. Please provide a field.");
        }

        if (!$fieldName = array_get($field, 'name')) {
            abort(403, "Invalid request. Please provide a field name.");
        }

        if(!$items = $request->items) {
            abort(403, "Please select some items.");
        }

        if(!$ids = collect($items)->pluck('id')->all()) {
            abort(403, "No ids provided.");
        }

        UserRole::whereIn('id', $ids)->update([$fieldName => array_get($field, 'value')]);
        return response("Updated");
    }

    protected function view($view, $data = [])
    {
        return view($this->viewDir.".".$view, $data);
    }

    public function create()
    {
        abort(404);
    }

    public function show(Request $request, UserRole $userRole)
    {
        abort(404);
    }

    public function edit(Request $request, UserRole $userRole)
    {
        abort(404);
    }

}
