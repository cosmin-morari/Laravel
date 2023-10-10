<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidateRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\CheckoutMail;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class CheckoutController extends Controller
{
    public function checkout(ValidateRequest $request)
    {
        $idProductsInCart = session()->get('cart');
        $products = Product::whereIn('id', $idProductsInCart)->get();
        $toMail = $request->input('contactDetails');
        Mail::to($toMail)->send(new CheckoutMail($products, env('MAIL_FROM_ADDRESS')));
        session()->flush();
        return redirect()->route('index');
    }
}
