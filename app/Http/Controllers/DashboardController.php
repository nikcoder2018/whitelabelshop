<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendor;
use App\Product;
class DashboardController extends Controller
{
    public function index(){
        $data['total_vendors'] = Vendor::count();
        $data['total_products'] = Product::count();
        $data['total_enquiries'] = 0;
        $data['total_traffics'] = 0;

        return view('admin.contents.dashboard', $data);
    }
}
