<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Http\Request;

class IncomeExpenseController extends Controller
{
    public $viewDir = "report";

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
        $expense = Expense::with('expenseCategory')->where('date', '>=', $request->startDate)->where('date', '<=', $request->endDate)->where('shop_id', session('shop')->shop_id)->get();

        $income = [
            [
                'name' => 'asset sold',
                'cost' => 12000,
                'total' => 1
            ]
        ];
        $total = Expense::with('expenseCategory')->where('date', '>=', $request->startDate)->where('date', '<=', $request->endDate)->where('shop_id', session('shop')->shop_id)->sum('cost');
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
            'expenses' => $expense,
            'income' => $income,
            'totalCost' => $total,
        ];
    }
}