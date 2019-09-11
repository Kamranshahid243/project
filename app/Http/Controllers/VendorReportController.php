<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\Vendor;
use Illuminate\Http\Request;

class VendorReportController extends Controller
{
    public $viewDir = "report.vendor_report";

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return Vendor::findRequested();
        }
        return $this->view("index");
    }

    protected function view($view, $data = [])
    {
        return view($this->viewDir . "." . $view, $data);
    }

    public function VendorStockReport(Request $request)
    {
        if($request->wantsJson()) {
            return Purchase::findRequested();
        }
    }

        public function VendorStockReportPage(Request $request)
    {
        return view('report.vendor_report.vendor-profile',['id' => $request->id]);
    }

    public function vendorProfile(Request $request){
        return Vendor::with(['vendorCategory'])->where('shop_id',session('shop')->shop_id)->where('vendor_id',$request->id)->first();
    }

}
