<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Order;
use Illuminate\Http\Request;

class IncomeExpenseController extends Controller
{
    public $viewDir = "report.income_expense";

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return Expense::findRequested();
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

    public function incomeExpenseReport(Request $request)
    {
//        dd($request->startDate);
        $expense = Expense::with('expenseCategory')->where('date', '>=', $request->startDate)->where('date', '<=', $request->endDate)->where('shop_id', session('shop')->shop_id)->get();
        $expense = $expense->groupBy('category_id');
        $expenseArray=[];
        foreach ($expense as $key => $record)
        {
            $cost=0;
            foreach ($record as $cat)
            {
                $cost+=$cat['cost'];
            }
            $record[0]['total']=$cost;
            $expenseArray[]=$record;

        }
//dd($expenseArray);
        $income= Order::with('productCategory')->where('date', '>=', $request->startDate)->where('date', '<=', $request->endDate)->where('shop_id', session('shop')->shop_id)->get();
        $income=$income->groupBy('product_category');
        $incomeArray=[];
            foreach ($income as $key => $data){
                $price=0;
                foreach ($data as $info){
                    $price+=$info['price'];
                }
                $data[0]['amount']=$price;
                $incomeArray[]=$data;
            }

        $totalIncome = Order::with('productCategory')->where('date', '>=', $request->startDate)->where('date', '<=', $request->endDate)->where('shop_id', session('shop')->shop_id)->sum('price');
//        dd($income->sum('price'));
//        $income = [
//            [
//                'name' => 'asset sold',
//                'cost' => 12000,
//                'total' => 1
//            ]
//        ];
        $totalExpense = Expense::with('expenseCategory')->where('date', '>=', $request->startDate)->where('date', '<=', $request->endDate)->where('shop_id', session('shop')->shop_id)->sum('cost');
        $diff = abs(count($expense) - count($income));
        for ($i = 0; $i <= $diff; $i++) {
            if (count($expense) > count($income)) {
                $income[] = [];
            }
            if (count($income) > count($expense)) {
                $expense[] = [];
            }
        }
        return [
            'expenses' => $expenseArray,
            'incomes' => $incomeArray,
            'totalExpense' => $totalExpense,
            'totalIncome' => $totalIncome,
        ];
    }
}