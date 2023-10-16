<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateCheckoutRequest;
use App\Models\products_orders;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\CheckoutMail;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class CheckoutController extends Controller
{
    public function checkout(ValidateCheckoutRequest $request)
    {
        $idProductsInCart = session()->get('cart');
        $toMail = $request->input('contactDetails');
        $products = Product::whereIn('id', $idProductsInCart)->get();

        if (!empty($products)) {
            try {
                $totalPrice = Product::whereIn('id', $idProductsInCart)->sum('price');

                Mail::to(config('credentialsAdmin.adminEmail'))->send(new CheckoutMail($products, $toMail));

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
            } catch (Throwable $err) {
                Log::error($err);
            }
            session()->forget('cart');
            return redirect()->route('index');
        } else {
            return redirect()->route('cart')->with('message', trans('messages.error'));
        }
    }
}
