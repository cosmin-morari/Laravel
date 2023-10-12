<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateCheckoutRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\CheckoutMail;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function checkout(ValidateCheckoutRequest $request)
    {
        $idProductsInCart = session()->get('cart');
        $toMail = $request->input('contactDetails');

        if ($idProductsInCart) {
            $products = Product::whereIn('id', $idProductsInCart)->get();

            Mail::to(env('MAIL_FROM_ADDRESS'))->send(new CheckoutMail($products, $toMail));


            session()->forget('cart');
            return redirect()->route('index');
        } else {
            throw new \ErrorException(trans('messages.error'));
        }
    }
}
