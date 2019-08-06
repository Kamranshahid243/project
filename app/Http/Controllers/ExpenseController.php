<?php

namespace App\Http\Controllers;

use App\Expense;
use App\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public $viewDir = "expense";

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return Expense::findRequested();
        }
        return $this->view("index");
    }

    public function store(Request $request)
    {
        $this->validate($request, Expense::validationRules());
        $data = $request->all();
//        return Expense::create($data);
//        $data = $request->all();
        $expense = new Expense([
            'shop_id' => session('shop')->shop_id,
            'category_id' => $request->category_id,
            'cost' => $request->cost,

            'date' => date('Y-m-d', strtotime($request->date)),

            'date' => date('Y-m-d', strtotime($request->date)),

        ]);
        $expense->save();
        return "Expense Added";
    }

    public function update($id, Request $request)
    {

        $expense = Expense::where('id', $id)->first();

        $expense = Expense::where('expense_id', $id)->first();

        if ($request->wantsJson()) {
            $data = [$request->name => $request->value];
//            $validator = \Validator::make($data, Expense::validationRules($request->name));
//            if ($validator->fails())
//                return response($validator->errors()->first($request->name), 403);
            $expense->update($data);
            return "Expense updated.";
        }

        $this->validate($request, Expense::validationRules());
        $expense->update($request->all());
        return redirect('/expenses');
    }

    public function destroy(Request $request, Expense $expense)
    {
        $expense->delete();
        return "Expense deleted";
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

        Expense::whereIn('id', $ids)->delete();
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

        if (!in_array($fieldName, Expense::$bulkEditableFields)) {
            abort(403, "Bulk editing the {$fieldName} is not allowed.");
        }

        if (!$items = $request->items) {
            abort(403, "Please select some items.");
        }

        if (!$ids = collect($items)->pluck('id')->all()) {
            abort(403, "No ids provided.");
        }

        Expense::whereIn('id', $ids)->update([$fieldName => date('Y-m-d', strtotime(array_get($field, 'value')))]);
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

    public function show(Request $request, Expense $expense)
    {
        abort(404);
    }

    public function edit(Request $request, Expense $expense)
    {
        abort(404);
    }

    public function allShops()
    {
        return Shop::get();
    }

    public function allExpenseCategories()
    {
        return ExpenseCategory::all();
    }


}
