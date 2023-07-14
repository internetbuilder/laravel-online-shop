<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public function index()
{
    $this->setPageTitle('Orders', 'List of all orders');
    $orders = Order::all();
    return view('admin.orders.index', compact('orders'));

}

public function show(Order $order)
{
    $this->setPageTitle('Order Details', $order->order_number);
    return view('admin.orders.show', compact('order'));
}

}
