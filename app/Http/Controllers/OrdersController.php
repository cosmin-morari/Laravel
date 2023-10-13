<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\products_orders;

class OrdersController extends Controller
{
    public function viewOrders()
    {
        $pivotTable = new products_orders;
        $data = $pivotTable
            ->select('orders.id', 'orders.date', 'orders.customer_details', 'orders.purchased_products', 'orders.total_price')
            ->join('orders', 'products_orders.order_id', 'orders.id')
            ->groupBy('orders.id')
            ->get();
        return view('orders', ['data' => $data]);
    }

    public function viewOrder($id)
    {
        $order = Order::findOrFail($id);

        return view('order', ['order' => $order]);
    }
}
