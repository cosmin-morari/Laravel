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

            if ($products) {
                // mail from user to admin
                $toUser = false;
                $toAdmin = true;
                Mail::to(env('MAIL_FROM_ADDRESS'))->send(new CheckoutMail($toUser, $toAdmin, $products, $toMail));

                // mail from admin to user
                $toUser = true;
                $toAdmin = false;
                Mail::to($toMail)->send(new CheckoutMail($toUser, $toAdmin, $products, env('MAIL_FROM_ADDRESS')));
                session()->forget('cart');
                return redirect()->route('index');
            }
        }
    }
}