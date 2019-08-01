<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Order;
use App\Product;
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
        $this->validate($request, Bill::validationRules());
        $bill = new Bill([
            'customer_id' => $request->customer_id,
            'date' => date('Y-m-d H:i:s'),
        ]);
        $bill->save();
        $items = \request('order');
        foreach ($items as $billitem) {
            $item = Product::where('product_id', $billitem['product_id'])->first();
            $oldNumber = $item->available_quantity - $billitem['available_quantity'];
            $data = ['available_quantity' => $oldNumber];
            $item->update($data);
            $order = new Order([
                'shop_type' => $shop['shop_type'],
                'shop_id' => $shop['shop_id'],
                'customer_id' => $request->customer_id,
                'bill_id' => $bill->id,
                'price' => $item->unit_price * $billitem['available_quantity'],
                'qty' => $billitem['available_quantity']
            ]);
            $order->save();
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
