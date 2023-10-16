<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateCheckoutRequest;
use App\Models\products_orders;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\CheckoutMail;
use App\Models\Product;
use App\Models\Order;
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

                Mail::to(env('MAIL_FROM_ADDRESS'))->send(new CheckoutMail($products, $toMail));

                // insert order table
                $order = new Order;
                $order->date = now();
                $order->name = $request->input('name');
                $order->contactDetails = $request->input('contactDetails');
                $order->comments = $request->input('comments');
                $order->total_price = $totalPrice;
                $order->save();

                //insert pivot table
                $pivot = new products_orders;
                $lastIdOrder = $order->latest()->first()->id;

                $insertData = array_reduce($idProductsInCart, function ($carry, $product_id) use ($lastIdOrder) {
                    $carry[] = [
                        'product_id' => $product_id,
                        'order_id' => $lastIdOrder
                    ];

                    return $carry;
                }, []);

                $pivot->insert($insertData);
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
