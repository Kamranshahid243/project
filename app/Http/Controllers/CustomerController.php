<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function index()
//    {
//        return view('customer.index');
//    }

    public $viewDir = "customer";

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
            return Customer::findRequested();
        }
        return $this->view("index");
    }

    public function store(Request $request)
    {
        $this->validate($request, Customer::validationRules());
        $data = $request->all();
        return Customer::create($data);
    }

    public function update(Request $request, Customer $user)
    {
        if ($request->wantsJson()) {
            $data = [$request->name => $request->value];
            $validator = \Validator::make($data, Customer::validationRules($request->name));
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

        if (!$ids = collect($items)->pluck('customer_id')->all()) {
            abort(403, "No ids provided.");
        }

        User::whereIn('id', $ids)->update([$fieldName => array_get($field, 'value')]);
        return response("Updated");
    }

    protected function view($view, $data = [])
    {
       $data['shop_name']= DB::table('customers')
            ->join('shops', 'customers.shop_id', '=', 'shops.shop_id')
            ->select('shops.shop_id','shops.shop_name')
            ->get();
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
