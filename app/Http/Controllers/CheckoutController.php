<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\CheckoutMail;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function checkout(ValidateRequest $request)
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
                session()->flush();
                return redirect()->route('index');
            }
        }
    }
}
