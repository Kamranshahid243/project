<?php

namespace App\Http\Controllers;

use App\VendorCategory;
use Illuminate\Http\Request;

class VendorCategoryController extends Controller
{
    public $viewDir = "vendor_category";

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return VendorCategory::findRequested();
        }
        return $this->view("index");
    }

    public function store(Request $request)
    {
        $this->validate($request, VendorCategory::validationRules());
        $data = $request->all();
        VendorCategory::create([
            'cat_name' => $request->cat_name,
            'shop_id' => session('shop')->shop_id,
            'status' => $request->status,
        ]);
        return "Vendor Category Added";
    }

    public function update($id, Request $request)
    {
        $category = VendorCategory::where('id', $id)->first();
        if ($request->wantsJson()) {
            $data = [$request->name => $request->value];
            $validator = \Validator::make($data, VendorCategory::validationRules($request->name));
            if ($validator->fails())
                return response($validator->errors()->first($request->name), 403);
            $category->update($data);
            return "Vendor Category updated.";
        }

        $this->validate($request, VendorCategory::validationRules());
        $category->update($request->all());
        return redirect('/vendor-category');
    }

    public function updateStatus(Request $request){
        $id=VendorCategory::all()->where('id',$request->id)->first();
        if($id->status==1){
            $id->update([
                'status' => '0',
            ]);
        }
        else{
            $id->update([
                'status' => '1',
            ]);
        }

    }

    public function destroy($id)
    {
        $category = VendorCategory::where('id', '=', $id)->delete();

        return "Vendor Category deleted";
    }

    public function bulkDelete(Request $request)
    {
        $items = $request->items;
        if (!$items) {
            abort(403, "Please select some items.");
        }

        if (!$ids = collect($items)->pluck('id')->all()) {
            abort(403, "No IDs provided.");
        }

        VendorCategory::whereIn('id', $ids)->delete();
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

        if (!in_array($fieldName, VendorCategory::$bulkEditableFields)) {
            abort(403, "Bulk editing the {$fieldName} is not allowed.");
        }

        if (!$items = $request->items) {
            abort(403, "Please select some items.");
        }

        if (!$ids = collect($items)->pluck('id')->all()) {
            abort(403, "No ids provided.");
        }

        VendorCategory::whereIn('id', $ids)->update([$fieldName => array_get($field, 'value')]);
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

    public function show(Request $request, ExpenseCategory $expense)
    {
        abort(404);
    }

    public function edit(Request $request, ExpenseCategory $expense)
    {
        abort(404);
    }

    public function allShops()
    {
        return Shop::get();
    }


}
