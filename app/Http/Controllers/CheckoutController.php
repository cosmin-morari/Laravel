<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateCheckoutRequest;
use App\Models\products_orders;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\CheckoutMail;
use App\Models\Product;
use App\Models\Order;

class CheckoutController extends Controller
{
    public function checkout(ValidateCheckoutRequest $request)
    {
        $idProductsInCart = session()->get('cart');
        $toMail = $request->input('contactDetails');

        if ($idProductsInCart) {
            $products = Product::whereIn('id', $idProductsInCart)->get();

            $totalPrice = Product::whereIn('id', $idProductsInCart)->sum('price');
            $productsInCart = Product::whereIn('id', $idProductsInCart)->pluck('title');
            $productsPurchased = implode(' ,', $productsInCart->toArray());
            $customerDetails = $request->input('name') . ', ' . $request->input('contactDetails') . ', ' . $request->input('comments');

            Mail::to(env('MAIL_FROM_ADDRESS'))->send(new CheckoutMail($products, $toMail));

            // insert order table
            $order = new Order;
            $order->date = now();
            $order->customer_details = $customerDetails;
            $order->purchased_products = $productsPurchased;
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

            session()->forget('cart');
            return redirect()->route('index');
        } else {
            throw new \ErrorException(trans('messages.error'));
        }
    }
}
