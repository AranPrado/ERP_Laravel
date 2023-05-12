<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{

    public function index()
    {
        $admins = User::where('is_admin', true)
            ->limit(10)
            ->orderBy('id','desc')
            ->get();

        $clients = User::where('is_admin', null)
            ->orWhere('is_admin', false)
            ->limit(10)
            ->orderBy('id','desc')
            ->get();

        $product = Product::
            orderBy('id','desc')
            ->limit(10)
            ->get();
        
        return view('erp.dashboard.index')
            ->with(compact('admins', 'clients','product'));
    }

}
