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
    public $viewDir = "order";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return Bill::findRequested();
        }
        return $this->view('index');
    }

    public function searchBill(Request $request)
    {
        if ($request->wantsJson()) {
            return Bill::findRequested();
        }
        return $this->view('index');
    }

    protected function view($view, $data = [])
    {
        return view($this->viewDir . "." . $view, $data);
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


        /*Storing values in Bill Table*/
        $this->validate($request, Bill::validationRules());
        $bill = new Bill([
            'customer_id' => $customer['customer_id'],
            'paid' => $request->paid,
            'shop_id' => session('shop')->shop_id,
            'date' => date('Y-m-d H:i:s'),
        ]);
        $bill->save();
        $orders = $request->order;
        foreach ($orders as $order) {
            $income = new IncomeModel([
                'product_name' => $order['product_name'],
                'price' => $order['unit_price'] * $order['available_quantity'],
                'date' => date('Y-m-d H:i:s')
            ]);
            $income->save();
        }
        /*Updating Values in Products Table*/
        $items = \request('order');
        foreach ($items as $billitem) {
            $item = Product::where('product_id', $billitem['product_id'])->first();
            $oldNumber = $item->available_quantity - $billitem['available_quantity'];
            if ($oldNumber == 0) {
                $item->update(['product_status' => 'Unavailable']);
            }
            $data = ['available_quantity' => $oldNumber];
            $item->update($data);
            /*Storing Values in Order Table*/
            $order = new Order([
                'shop_type' => session('shop')->shop_type,
                'shop_id' => session('shop')->shop_id,
                'customer_id' => $customer['customer_id'],
                'product_id' => $billitem['product_id'],
                'bill_id' => $bill->id,
                'product_category' => $billitem['product_category'],
                'price' => $item->unit_price * $billitem['available_quantity'],
                'qty' => $billitem['available_quantity'],
                'date' => date('Y-m-d'),
            ]);
            $order->save();
        }
        return $order;
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
        if ($request->wantsJson()) {
            $data = [$request->name => $request->value];
            if ($data['paid']) {

                $bill = Bill::find($id);
                $newAmount = $bill->paid + $request->value;
                if ($newAmount > $bill->total) {
                    abort(404, 'Amount is bigger then pending amount');
                } else {
                    $bill->update(['paid' => $newAmount]);
                    return $bill;
                }

            }
        }
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
