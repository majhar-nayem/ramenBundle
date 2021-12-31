<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index()
    {
        $products = Product::count();
        $orders = Order::count();
        $users = User::count();

        return response()->json([
           'users' => $users,
           'products' => $products,
           'orders' => $orders,
        ]);
    }
}
