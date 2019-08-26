<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class ProductSummaryController extends Controller
{
    public $viewDir = "report.product_summary";

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return Order::findRequested();
        }
        return $this->view("index");
    }

    protected function view($view, $data = [])
    {
        return view($this->viewDir . "." . $view, $data);
    }

    public function create()
    {
        abort(404);
    }

    public function show(Request $request, Expense $expense)
    {
        abort(404);
    }

    public function edit(Request $request, Expense $expense)
    {
        abort(404);
    }

    public function ProductSummaryReport(Request $request)
    {
//        if ($request->wantsJson()){
        $products = Order::with(['shop', 'customer', 'products', 'productCategory'])->where('date', '>=', $request->startDate)->where('date', '<=', $request->endDate)->where('shop_id', session('shop')->shop_id);
//        }
//        $groupedproducts = $products->groupBy('product_id')->paginate();
        $groupedproducts = $products->paginate();
        $price=0;
        foreach ($groupedproducts as $product){
            $price+= $product->price;
        }
        return $price;

//        $max=0;
//        $min=0;
//        for ($i = 0; $i < $groupedproducts['total']; $i++) {
//            if($products[$i]['qty'] > $products[$max]['qty']){
//                $max=$i;
//            }
//            if ($products[$i]['qty'] < $products[$min]['qty']) {
//                $min = $i;
//            }
//        }
//        $maxProduct=Order::with('productCategory')->with('products')->where('date', '>=', $request->startDate)->where('date', '<=', $request->endDate)->where('shop_id', session('shop')->shop_id)->where('qty', $products[$max]['qty'])->get();
//
//        $minProduct = Order::with('productCategory')->with('products')->where('date', '>=', $request->startDate)->where('date', '<=', $request->endDate)->where('shop_id', session('shop')->shop_id)->where('qty', $products[$min]['qty'])->get();
//
//
        $productsArray=[];
//        return $products;
//    return $groupedproducts;
//        $index=0;
//        foreach ($groupedproducts as $product) {
//            $price = 0;
//            $qty=0;
//            foreach ($product as $info) {
//                return $info;
//                $price += $info[0]['price'];
//                $qty += $info[$index]['qty'];
//            }
//            $product['amount'] = $price;
//            $product['quantity'] = $qty;
//            $productsArray[] = $product;
//        }
return ['allProducts' => $productsArray,
//        'maxProduct' => $maxProduct,
//        'minProduct' => $minProduct,
    ];
    }
}
