<?php

namespace App\Http\Controllers;

use App\Bill;
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
            return Order::findRequested();
        }
        return $this->view("index");
    }

    public function store(Request $request)
    {
        $this->validate($request, Order::validationRules());
        $data = $request->all();
        return Order::create($data);
    }

    public function updateCustomer($id, Request $request)
    {
        $data = [$request->name => $request->value];
        $order = Bill::where('id', $id)->first()->update($data);
        return 'string';
    }

    public function update(Request $request, Order $order)
    {


        if ($request->wantsJson()) {
            return $order->get();
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

    public function destroy(Order $order)
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

        if (!$ids = collect($items)->pluck('id')->all()) {
            abort(403, "No ids provided.");
        }

        Order::whereIn('id', $ids)->delete();
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

        Order::whereIn('id', $ids)->update([$fieldName => array_get($field, 'value')]);
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

    public function openReciept()
    {
        $data = Bill::with(['order.product', 'customer'])->orderby('id', 'dec')->latest()->first();
        return $data;
    }

    public function showReciept(Request $request)
    {
        return view('order.reciept', ['data', $request->all()]);
    }

    public function SearchOrder(Request $request)
    {
        $order = Order::where('id', '=', $request->id)->get();
        return $order;
    }

    public function annualSale()
    {
        $prices = [];
        for ($m = 1; $m <= date('m'); $m++) {
            $sales = Order::where('shop_id', '=', session('shop')->shop_id)->where('date', '>=', date('Y-' . sprintf("%02d", $m) . '-01'))->where('date', '<=', date('Y-' . sprintf("%02d", $m) . '-t'))->sum('price');

            $prices[] = $sales;
        }
        return $prices;
    }

    public function qtySale()
    {
        return $qtySales = \App\Product::where('shop_id', '=', session('shop')->shop_id)->limit(15)->get();
    }

    public function profitSale()
    {
        return Product::with('purchase')->where('shop_id', '=', session('shop')->shop_id)->limit(15)->get();
    }

    public function topSeller()
    {
        return $qtyProducts = Product::where('shop_id', '=', session('shop')->shop_id)->get();
        $grouped = $qtyProducts->groupBy('product_id');
        $quantity = [];
        $maxQtyProduct = [];
        foreach ($grouped as $max) {
            $quantity[] = $max->sum('qty');
            if (max($quantity)) {
                $maxQtyProduct = $max[0];
            }
        }
        $sale = [];
        $purchase = [];
        foreach ($grouped as $maxProfit) {
            $sale[] = $maxProfit->sum('price');
            $purchase[] = $maxProfit[2]->qty;
        }
        return $purchase;


//$qtyProducts= Order::with('product')->where('shop_id', '=', session('shop')->shop_id)->where('date', '>=', date('Y-m-01'))->where('date', '<=', date('Y-m-d'))->get();
//       $grouped=$qtyProducts->groupBy('product_id');
//      $quantity=[];
//      $maxQtyProduct=[];
//      foreach ($grouped as $max){
//          $quantity[]= $max->sum('qty');
//          if(max($quantity)) {
//              $maxQtyProduct=$max[0];
//          }
//      }
//      $sale=[];
//      $purchase=[];
//        foreach ($grouped as $maxProfit){
//            $sale[]=$maxProfit->sum('price');
//            $purchase[]=$maxProfit[2]->qty;
//        }
//        return $purchase;
//        return [
//          'maxQuantity' => max($quantity),
//          'maxProduct' => $maxQtyProduct,
//        ];
    }
}
