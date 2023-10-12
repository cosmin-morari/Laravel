<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    public function productsView()
    {

        if (session('admin')) {
            $products = Product::all();
            return view('products', ['allProducts' => $products]);
        } else {
            return redirect()->route('login');
        }
    }

    public function logoutAdmin()
    {
        session()->forget('admin');
        return redirect()->route('login');
    }

    public function deleteProductFromDb($id){
        Product::where('id', $id)->delete();
        return redirect()->back();
    }

    public function addProductView(){
        return view('product', ['destination' => 'addProduct']);
    }

    public function editProduct($id){
        $product = Product::findOrFail($id);
        return view('product', ['product' => $product, 'destination' => 'editProduct']);
    }
}
