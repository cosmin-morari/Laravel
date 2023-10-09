<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Iluminate\Session\SessionManage;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        $idProductsInCart = session()->get('cart');
        $products = ($idProductsInCart) ? Product::whereNotIn('id', $idProductsInCart)->get() : Product::all();
        return view('index', ['allProducts' => $products]);
    }

    public function cart()
    {
        $idProductsInCart = session()->get('cart');
        $products = Product::whereIn('id', $idProductsInCart)->get();
        if ($products) {
            return view('cart', ['products' =>  $products]);
        } else {
            return view('cart', ['empty' =>  trans('messages.emptyCart')]);
        }
    }

    public function store($id)
    {
        $product = Product::find($id);
        $cart = session()->get('cart');

        if (!in_array($product->id, session('cart') ?? [])) {
            $cart = $product->id;
            session()->push('cart', $cart);
        }
        return redirect()->back();
    }

    public function deleteProductFromCart($id)
    {
        //
    }
}
