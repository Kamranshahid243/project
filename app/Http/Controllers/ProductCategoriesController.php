<?php

namespace App\Http\Controllers;

use App\ProductCategory;
use Dotenv\Validator;
use Illuminate\Http\Request;

class ProductCategoriesController extends Controller
{
    public $viewDir = "product_category";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return ProductCategory::findRequested();
        }
        return $this->view("index");
    }

    // getting shop id for purchases
    public function getShopId()
    {
        $shop_id = ProductCategory::where('shop_id', '=', session('shop')->shop_id)->get();
        return $shop_id;
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
        $this->validate($request, ProductCategory::validationRules());
        ProductCategory::create([
            'category_name' => $request->category_name,
            'shop_id' => session('shop')->shop_id,
            'status' => $request->status,
        ]);
        return "Expense Category Added";
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
    public function update(Request $request, $category_id)
    {
        $category = ProductCategory::where('id', '=', $category_id);
        if ($request->wantsJson()) {
            $data = [$request->name => $request->value];
            $validator = \Validator::make($data, ProductCategory::validationRules($request->name));
            if ($validator->fails())
                return response($validator->errors()->first($request->name), 403);
            $category->update($data);
            return "Updated";
        }
    }

    public function status(Request $request)
    {
        $product = ProductCategory::find(\request('id'));
        $product->status = $product->status == 0 ? 1 : 0;
        $product->save();
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $product_category)
    {
        $product_category->delete();
        return "record deleted";
    }
}

