<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Routing\Controller;

class OrdersController extends Controller
{
    public function viewOrders()
    {
        $data = Order::get();
        return view('orders', ['data' => $data]);
    }

    public function viewOrder($id)
    {
        $order = Order::findOrFail($id);
        $products= $order->products()->pluck('products.title')->toArray();
        $products = implode(' ,', $products).'.';
        
        return view('order', ['order' => $order, 'products' =>$products ]);
    }
}
