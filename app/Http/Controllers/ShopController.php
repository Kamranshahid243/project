<?php

namespace App\Http\Controllers;

use App\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public $viewDir = "shop";


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
            return Shop::findRequested();
        }
        return $this->view("index");
    }

    public function store(Request $request)
    {
        $this->validate($request, Shop::validationRules());
        $data = $request->all();
        $data['shop_name'] = $data['shop_name'];
        $data['shop_address'] = $data['shop_address'];
        $data['shop_type'] = $data['shop_type'];
        $data['printer_type'] = $data['printer_type'];
        return Shop::create($data);
    }

    public function update(Request $request, Shop $shop)
    {
        if ($request->wantsJson()) {
            $data = [$request->name => $request->value];
            $validator = \Validator::make($data, Shop::validationRules($request->name));
            if ($validator->fails())
                return response($validator->errors()->first($request->name), 403);
            $shop->update($data);
            return "Shop updated.";
        }

        $this->validate($request, Shop::validationRules());
        $shop->update($request->all());
        return redirect('/shops');
    }

    public function destroy(Request $request, Shop $shop)
    {
        $shop->delete();
        return "Shop deleted";
    }

    public function bulkDelete(Request $request)
    {
        $items = $request->items;
        if (!$items) {
            abort(403, "Please select some items.");
        }

        if (!$ids = collect($items)->pluck('shop_id')->all()) {
            abort(403, "No IDs provided.");
        }

        Shop::whereIn('shop_id', $ids)->delete();
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

        if (!in_array($fieldName, Shop::$bulkEditableFields)) {
            abort(403, "Bulk editing the {$fieldName} is not allowed.");
        }

        if (!$items = $request->items) {
            abort(403, "Please select some items.");
        }

        if (!$ids = collect($items)->pluck('shop_id')->all()) {
            abort(403, "No ids provided.");
        }

        Shop::whereIn('shop_id', $ids)->update([$fieldName => array_get($field, 'value')]);
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

    public function allShops()
    {
        return Shop::all();
    }

}
