<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Expense;
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
//        return Product::all();
        return $qtySales = \App\Product::where('shop_id', '=', session('shop')->shop_id)->limit(15)->get();
    }

    public function profitSale()
    {
        return Product::with('purchase')->where('shop_id', '=', session('shop')->shop_id)->limit(15)->get();
    }

    public function topSeller()
    {
        $monthlyProducts = Product::join('orders', 'orders.product_id', 'products.product_id')->
        join('purchases', 'purchases.id', 'products.purchase_id')->
        select('products.product_name', 'products.product_id', 'orders.qty', 'orders.created_at', 'orders.date', 'purchases.purchase_cost', 'purchases.customer_cost', 'products.unit_price')->where('orders.date', '>=', date('Y-m-01'))->where('orders.date', '<=', date('Y-m-t'))->get();
        $groupedMonthly = $monthlyProducts->groupBy('product_id');
        $todayProducts = Product::join('orders', 'orders.product_id', 'products.product_id')->
        join('purchases', 'purchases.id', 'products.purchase_id')->
        select('products.product_name', 'products.product_id', 'orders.qty', 'orders.created_at', 'orders.date', 'purchases.purchase_cost', 'purchases.customer_cost', 'products.unit_price')->where('orders.date', date('Y-m-d'))->get();
        $groupedDaily = $todayProducts->groupBy('product_id');
        $todayExpense = Expense::where('shop_id', session('shop')->shop_id)->where('date', date('Y-m-d'))->get()->sum('cost');
        $quantity = [];
        $price = [];
        $saleToday = 0;
        $profitToday = 0;
        $maxQtyProduct = [];
        $maxProfitProduct = [];
        foreach ($groupedMonthly as $product) {
            $quantity[] = $product->sum('qty');
            if ($product->sum('qty') == max($quantity)) {
                $maxQtyProduct = $product;
            }
            $price[] = ($product[0]['unit_price'] - $product[0]['purchase_cost']) * $product->sum('qty');
            if (($product[0]['unit_price'] - $product[0]['purchase_cost']) * $product->sum('qty') == max($price)) {
                $maxProfitProduct = $product;
            }
        }
        foreach ($groupedDaily as $product) {
            //today total sale
            $saleToday += ($product->sum('qty') * $product[0]['unit_price']);
////            saleEnd
//            total profit today
            $profitToday += ($product[0]['unit_price'] * $product->sum('qty')) - ($product[0]['purchase_cost'] * $product->sum('qty'));
//            profit
        }
        return [
            'maxQtyProduct' => $maxQtyProduct[0],
            'maxQuantity' => max($quantity),
            'maxProfitProduct' => $maxProfitProduct[0],
            'maxProfit' => max($price),
            'todayTotalSale' => $saleToday,
            'todayTotalProfit' => $profitToday,
            'todayExpense' => $todayExpense,
            'cashInHand' => $saleToday - $todayExpense,
        ];
    }
}
