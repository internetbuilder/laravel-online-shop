<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function getOrders()
    {
        $orders = Order::where('user_id', auth()->user()->id)->get();

        return view('site.pages.account.orders', compact('orders'));
    }

}
