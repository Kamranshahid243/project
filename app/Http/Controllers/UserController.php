<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Shop;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function shopSession(Request $request, $id)
    {
        $shop = Shop::where('shop_id', '=', $id)->first();
        session(['shop' => $shop]);
        return redirect()->back();
    }
    public $viewDir = "user";

    public function changePassword(Request $request)
    {
        $admin = \Auth::user();
        $this->validate($request, [
            "currentPassword" => "required",
            "newPassword" => "required|confirmed|min:6",
            "newPassword_confirmation" => "required",
        ]);

        if (!\Auth::attempt(['email' => $admin->email, 'password' => $request->currentPassword])) {
            abort(400, 'Current password does not match.');
        }

        $admin->password = bcrypt($request->newPassword);
        $admin->save();

        return response('Updated');
    }

    public function profile(Request $request)
    {
        if ($request->wantsJson()) {
            return \Auth::user();
        }
        return $this->view("profile");
    }

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return User::findRequested();
        }
        return $this->view("index");
    }

    public function store(Request $request)
    {
        if (Auth::user()->role->role == 'Super Admin') {
            $this->validate($request, User::validationRules());
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);
            return User::create($data);
        }
        else{
            $this->validate($request, User::validationRules());
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);
            $data['shop_id'] = session('shop')->shop_id;
            return User::create($data);
        }
    }

    public function update(Request $request, User $user)
    {
        if ($request->wantsJson()) {
            $data = [$request->name => $request->value];
            $validator = \Validator::make($data, User::validationRules($request->name));
            if ($validator->fails())
                return response($validator->errors()->first($request->name), 403);
            $user->update($data);
            return "User updated.";
        }

        $this->validate($request, User::validationRules());
        $user->update($request->all());
        return redirect('/user');
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();
        return "User deleted";
    }

    public function bulkDelete(Request $request)
    {
        $items = $request->items;
        if (!$items) {
            abort(403, "Please select some items.");
        }

        if (!$ids = collect($items)->pluck('id')->all()) {
            abort(403, "No ids provided.");
        }

        User::whereIn('id', $ids)->delete();
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

        if (!in_array($fieldName, User::$bulkEditableFields)) {
            abort(403, "Bulk editing the {$fieldName} is not allowed.");
        }

        if (!$items = $request->items) {
            abort(403, "Please select some items.");
        }

        if (!$ids = collect($items)->pluck('id')->all()) {
            abort(403, "No ids provided.");
        }

        User::whereIn('id', $ids)->update([$fieldName => array_get($field, 'value')]);
        return response("Updated");
    }

    protected function view($view, $data = [])
    {
        return view($this->viewDir . "." . $view, $data);
    }

    public function create()
    {
        abort(404);
    }

    public function show(Request $request, User $user)
    {
        abort(404);
    }

    public function edit(Request $request, User $user)
    {
        abort(404);
    }

}
