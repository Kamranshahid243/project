<?php

namespace App\Http\Controllers;

use App\Product;
use App\Purchase;
use App\Shop;
use App\Vendor;
use App\VendorCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchasesController extends Controller
{
    public $viewDir = "purchase";

    public function index(Request $request, Purchase $purchase)
    {
        if ($request->wantsJson()) {
            return $purchase::findRequested();
        }
        return $this->view("index");
    }

    public function store(Request $request)
    {
        $this->validate($request, Purchase::validationRules());
        $data = $request->all();
        if ($request->paid < 0 && $request->paid > ($request->quantity * $request->purchase_cost)) {
            return "Paid Amount is greater lesser than Total Amount";
        }
        if (!Product::where('shop_id', session('shop')->shop_id)->where('product_name', $request->product_name)->first()) {
            Product::create([
                'shop_id' => session('shop')->shop_id,
                'product_name' => $request->product_name,
                'product_code' => $request->product_code,
                'product_category' => $request->category_id,
                'product_description' => $request->product_description,
                'available_quantity' => $request->quantity,
                'unit_price' => $request->customer_cost,
                'product_status' => $request->product_status,

            ]);
        } else {
            $qty = Product::where('shop_id', session('shop')->shop_id)->where('product_name', $request->product_name)->first()->available_quantity;

            Product::where('shop_id', session('shop')->shop_id)->where('product_name', $request->product_name)->update([
                'product_code' => $request->product_code,
                'product_description' => $request->product_description,
                'available_quantity' => $qty + $request->quantity,
                'unit_price' => $request->customer_cost,
                'product_status' => $request->product_status,
            ]);
        }
        return Purchase::create([
            'shop_id' => session('shop')->shop_id,
            'vendor_id' => $request->vendor_id,
            'product_name' => $request->product_name,
            'quantity' => $request->quantity,
            'original_cost' => $request->original_cost,
            'purchase_cost' => $request->purchase_cost,
            'customer_cost' => $request->customer_cost,
            'paid' => $request->paid,
            'payable' => ($request->quantity * $request->purchase_cost) - $request->paid,
            'total' => ($request->quantity * $request->purchase_cost),
            'date' => date('Y-m-d', strtotime($request->date)),
        ]);
    }

    public function update(Request $request, Purchase $purchase)
    {
        if ($request->wantsJson()) {
            if ($request->name == 'paid') {
                $data = [$request->name => $request->value,
                    'payable' => $purchase->total - $request->value];
            } else {
                $data = [$request->name => $request->value];
            }
            $validator = \Validator::make($data, Purchase::validationRules($request->name));
            if ($validator->fails())
                return response($validator->errors()->first($request->name), 403);
            $purchase->update($data);
            return "Purchase updated.";
        }

        $this->validate($request, Purchase::validationRules());
        $purchase->update($request->all());
        return redirect('/purchases');
    }

    public function destroy(Request $request, Purchase $purchase)
    {
        $purchase->delete();
        return "Purchase deleted";
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

        Purchase::whereIn('id', $ids)->delete();
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

        if (!in_array($fieldName, Purchase::$bulkEditableFields)) {
            abort(403, "Bulk editing the {$fieldName} is not allowed.");
        }

        if (!$items = $request->items) {
            abort(403, "Please select some items.");
        }

        if (!$ids = collect($items)->pluck('id')->all()) {
            abort(403, "No ids provided.");
        }

        Purchase::whereIn('id', $ids)->update([$fieldName => array_get($field, 'value')]);
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

    public function show(Request $request, Customer $user)
    {
        abort(404);
    }

    public function edit(Request $request, Customer $user)
    {
        abort(404);
    }

    public function vendors(Request $request)
    {
        return Vendor::where('shop_id', session('shop')->shop_id)->get();
    }
}
