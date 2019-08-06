<?php

namespace App\Http\Controllers;

use App\Vendor;
use App\VendorCategory;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->WantsJson()) {
            return Vendor::findRequested();
        }
        return view('vendor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Vendor::validationRules());
        Vendor::create([
            'shop_id' => session('shop')->shop_id,
            'v_cat_id' => $request->v_cat_id,
            'vendor_name' => $request->vendor_name,
            'vendor_address' => $request->vendor_address,
            'vendor_phone' => $request->vendor_phone,
            'vendor_email' => $request->vendor_email,
            'vendor_status' => $request->vendor_status,
        ]);
        return "Vendor Added Successfully";
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $vendor_id)
    {
        $vendor = Vendor::where('vendor_id', '=', $vendor_id);
        if ($request->wantsJson()) {
            $data = [$request->name => $request->value];
            $validator = \Validator::make($data, Vendor::validationRules($request->name));
            if ($validator->fails())
                return response($validator->errors()->first($request->name), 403);

            $vendor->update($data);
            return "Vendor updated.";
        }

        $this->validate($request, Vendor::validationRules());
        $vendor->update($request->all());
        return redirect('/vendor');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($vendor_id)
    {
        $vendor = Vendor::where('vendor_id', '=', $vendor_id)->delete();
        return "Deleted Succesfully";
    }

    public function bulkEdit(Request $request)
    {
        if (!$field = $request->field) {
            abort(403, "Invalid request. Please provide a field.");
        }

        if (!$fieldName = array_get($field, 'name')) {
            abort(403, "Invalid request. Please provide a field name.");
        }

        if (!in_array($fieldName, Vendor::$bulkEditableFields)) {
            abort(403, "Bulk editing the {$fieldName} is not allowed.");
        }

        if (!$items = $request->items) {
            abort(403, "Please select some items.");
        }

        if (!$ids = collect($items)->pluck('vendor_id')->all()) {
            abort(403, "No ids provided.");
        }

        Vendor::whereIn('vendor_id', $ids)->update([$fieldName => array_get($field, 'value')]);
        return response("Updated");
    }

    public function bulkDelete(Request $request)
    {
        $items = $request->items;
        if (!$items) {
            abort(403, "Please select some items.");
        }

        if (!$ids = collect($items)->pluck('vendor_id')->all()) {
            abort(403, "No IDs provided.");
        }

        Vendor::whereIn('vendor_id', $ids)->delete();
        return response("Deleted");
    }

    public function vendorCategories()
    {
        return VendorCategory::where('shop_id', session('shop')->shop_id)->get();
    }
}
