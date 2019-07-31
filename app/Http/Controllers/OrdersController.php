<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\Shop;
use App\Customer;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public $viewDir = "order";

    public function index(Request $request, Order $order)
    {
        if ($request->wantsJson()) {
            return $order::findRequested();
        }
        return $this->view("index");
    }

    public function store(Request $request)
    {
        $this->validate($request, Order::validationRules());
        $data = $request->all();
        return Order::create($data);
    }

    public function update(Request $request, Order $order)
    {
        if ($request->wantsJson()) {
            $data = [$request->name => $request->value];
            $validator = \Validator::make($data, Order::validationRules($request->name));
            if ($validator->fails())
                return response($validator->errors()->first($request->name), 403);
            $order->update($data);
            return "Order updated.";
        }

        $this->validate($request, Order::validationRules());
        $order->update($request->all());
        return redirect('/orders');
    }

    public function destroy(Request $request, Order $order)
    {
        $order->delete();
        return "Order deleted";
    }

    public function bulkDelete(Request $request)
    {
        $items = $request->items;
        if (!$items) {
            abort(403, "Please select some items.");
        }

        if (!$ids = collect($items)->pluck('order_id')->all()) {
            abort(403, "No ids provided.");
        }

        Order::whereIn('order_id', $ids)->delete();
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

        if (!in_array($fieldName, Order::$bulkEditableFields)) {
            abort(403, "Bulk editing the {$fieldName} is not allowed.");
        }

        if (!$items = $request->items) {
            abort(403, "Please select some items.");
        }

        if (!$ids = collect($items)->pluck('order_id')->all()) {
            abort(403, "No ids provided.");
        }

        Order::whereIn('order_id', $ids)->update([$fieldName => array_get($field, 'value')]);
        return response("Updated");
    }

    protected function view($view, $data = [])
    {


//        dd($data);
        return view($this->viewDir . "." . $view, $data);
    }

    public function create()
    {
        abort(404);
    }

    public function show(Request $request, Order $order)
    {
        abort(404);
    }

    public function edit(Request $request, Order $order)
    {
        abort(404);
    }

    public function addOrder()
    {
        return view('order.addOrderPage');
    }

}
