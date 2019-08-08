<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Order;
use App\Product;
use App\IncomeModel;
use function Composer\Autoload\includeFile;
use Illuminate\Http\Request;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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


        $shop = json_decode($request->shop, true);
        $customer = json_decode($request->customer, true);

        $this->validate($request, Bill::validationRules());
        $bill = new Bill([
            'customer_id' => $customer['customer_id'],
            'date' => date('Y-m-d H:i:s'),
        ]);
        $bill->save();
        $items = \request('order');
        foreach ($items as $billitem) {
            $item = Product::where('product_id', $billitem['product_id'])->first();
            $oldNumber = $item->available_quantity - $billitem['available_quantity'];
            if ($oldNumber == 0) {
                $item->update(['product_status' => 'Unavailable']);
            }
            $data = ['available_quantity' => $oldNumber];
            $item->update($data);
            $order = new Order([
                'shop_type' => session('shop')->shop_type,
                'shop_id' => session('shop')->shop_id,
                'customer_id' => $customer['customer_id'],
                'product_id' => $billitem['product_id'],
                'customer_name' => $customer['customer_name'],
                'bill_id' => $bill->id,
                'product_category' => $billitem['product_category'],
                'price' => $item->unit_price * $billitem['available_quantity'],
                'payable' => (($item->unit_price * $billitem['available_quantity']) - \request('paid')),
                'qty' => $billitem['available_quantity'],
                'date' => date('Y-m-d'),
                'order_status' => (($item->unit_price * $billitem['available_quantity']) > \request('paid')) ? 'Pending' : 'Paid',
            ]);
            $order->save();
        }

        $orders = $request->order;
        foreach ($orders as $order) {
            $income = new IncomeModel([
                'product_name' => $order['product_name'],
                'price' => $order['unit_price'] * $order['available_quantity'],
                'date' => date('Y-m-d H:i:s')
            ]);
            $income->save();
        }
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
