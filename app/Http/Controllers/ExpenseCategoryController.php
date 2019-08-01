<?php

namespace App\Http\Controllers;

use App\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public $viewDir = "expense_category";


    public function profile(Request $request)
    {
        if ($request->wantsJson()) {
            return \Auth::user();
        }
        return $this->view("profile");
    }

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return ExpenseCategory::findRequested();
        }
        return $this->view("index");
    }

    public function store(Request $request)
    {
        $this->validate($request, ExpenseCategory::validationRules());
        $data = $request->all();
        return ExpenseCategory::create([
            'cat_name' => $request->cat_name,
            'shop_id' => session('shop')->shop_id,
            'status' => $request->status,
        ]);
    }

    public function update($id, Request $request)
    {
        $expense = ExpenseCategory::where('id', $id)->first();
        if ($request->wantsJson()) {
            $data = [$request->name => $request->value];
//            $validator = \Validator::make($data, Expense::validationRules($request->name));
//            if ($validator->fails())
//                return response($validator->errors()->first($request->name), 403);
            $expense->update($data);
            return "Expense updated.";
        }

        $this->validate($request, ExpenseCategory::validationRules());
        $expense->update($request->all());
        return redirect('/expenses');
    }

    public function destroy($expense_id)
    {
 $category = ExpenseCategory::where('id', '=', $expense_id)->delete();

        return "Expense Category deleted";
    }

    public function bulkDelete(Request $request)
    {
        $items = $request->items;
        if (!$items) {
            abort(403, "Please select some items.");
        }

        if (!$ids = collect($items)->pluck('id')->all()) {
            abort(403, "No IDs provided.");
        }

        ExpenseCategory::whereIn('id', $ids)->delete();
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

        if (!in_array($fieldName, ExpenseCategory::$bulkEditableFields)) {
            abort(403, "Bulk editing the {$fieldName} is not allowed.");
        }

        if (!$items = $request->items) {
            abort(403, "Please select some items.");
        }

        if (!$ids = collect($items)->pluck('id')->all()) {
            abort(403, "No ids provided.");
        }

        ExpenseCategory::whereIn('id', $ids)->update([$fieldName => array_get($field, 'value')]);
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

    public function show(Request $request, ExpenseCategory $expense)
    {
        abort(404);
    }

    public function edit(Request $request, ExpenseCategory $expense)
    {
        abort(404);
    }

    public function allShops()
    {
        return Shop::get();
    }


}