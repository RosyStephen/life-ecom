<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Orders\Order;
use App\Models\Products\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data['productsCount'] =Product::count();
        $data['ordersCount'] = Order::count();
        $data['usersCount'] = User::role('customer')->count();
        return view('users.dashboard.index', $data);
    }
}
