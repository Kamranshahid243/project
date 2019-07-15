<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return Product::all();
        }
        return view('Products.index');

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
        $this->validate($request, Product::validationRules());
        $data = $request->all();
        $data['shop_id'] = $data['shop_id'];
        $data['product_name'] = $data['product_name'];
        $data['product_code'] = $data['product_code'];
        $data['product_description'] = $data['product_description'];
        $data['available_quantity'] = $data['available_quantity'];
        $data['unit_price'] = $data['unit_price'];
        return Product::create($data);
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
    public function update(Request $request, Product $product)
    {
        if ($request->wantsJson()) {
            $data = [$request->name => $request->value];
            $validator = \Validator::make($data, Product::validationRules($request->name));
            if ($validator->fails())
                return response($validator->errors()->first($request->name), 403);
            $product->update($data);
            return "Product updated.";
        }

        $this->validate($request, Product::validationRules());
        $product->update($request->all());
        return redirect('/showProducts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id)
    {
        $product = Product::where('product_id', '=', $product_id)->delete();
        return 'Deleted Succesfully';
    }

}
