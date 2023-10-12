<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;


class ProductController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    public function index()
    {
        $cartSession = session()->get('cart');
        $products = ($cartSession) ? Product::whereNotIn('id', $cartSession)->get() : Product::all();
        return view('index', ['allProducts' => $products]);
    }
    public function cart()
    {
        $cartSession = session()->get('cart');

        if ($cartSession) {
            $products = Product::whereIn('id', $cartSession)->get();

            if ($products) {
                return view('cart', ['products' =>  $products, 'toAdmin' => false, 'toUser' => false]);
            }
        } else {
            return view('cart', ['toAdmin' => false, 'toUser' => false, 'empty' =>  trans('messages.emptyCart')]);
        }
    }
    public function store($id)
    {
        $product = Product::findOrFail($id);
        $cartSession = session()->get('cart');

        if ($product) {
            if (!in_array($product->id, session('cart') ?? [])) {
                session()->push('cart', $product->id);
            }
        }

        return redirect()->back();
    }
    public function deleteProductFromCart($id)
    {
        $cartSession = session()->get('cart');
        $index = array_search($id, $cartSession);
        session()->forget("cart.$index");
        return redirect()->back();
    }
}
