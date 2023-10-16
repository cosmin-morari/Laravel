<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Routing\Controller;
use App\Http\Requests\ValidateCheckoutRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\CheckoutMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

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
        // $products = $order->products()->pluck('products.price', 'products.title')->toArray();
        // $products = Order::with('products')->pluck('price', 'title')->toArray();
        $products = Order::with('order_product:id, order_product, order_id, product_id, price')->get();
        dd($products);

        return view('order', ['order' => $order, 'products' => $products]);
    }

    public function checkout(ValidateCheckoutRequest $request)
    {
        $idProductsInCart = session()->get('cart');
        $toMail = $request->input('contactDetails');
        $products = Product::whereIn('id', $idProductsInCart)->get();

        if (!empty($products)) {

            // try {
            $totalPrice = Product::whereIn('id', $idProductsInCart)->sum('price');

            // Mail::to(config('credentialsAdmin.adminEmail'))->send(new CheckoutMail($products, $toMail));

            // insert order table
            $order = new Order;
            $order->date = now();
            $order->name = $request->input('name');
            $order->contactDetails = $request->input('contactDetails');
            $order->comments = $request->input('comments');
            $order->total_price = $totalPrice;
            $order->save();

            //insert pivot table
            $order->products()->attach($idProductsInCart);
            // } catch (Throwable $err) {
            //     Log::error($err);
            // }
            session()->forget('cart');
            return redirect()->route('index');
        } else {
            return redirect()->route('cart')->with('message', trans('messages.error'));
        }
    }

    public function productsView()
    {
        $products = Product::all();
        return view('products', ['allProducts' => $products]);
    }
}
