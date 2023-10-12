<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\ValidateAddProduct;

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

    public function deleteProductFromDb($id)
    {
        Product::where('id', $id)->delete();
        return redirect()->back();
    }

    public function addProductView()
    {
        return view('product', ['destination' => 'addProduct']);
    }

    public function editProductView($id)
    {
        $product = Product::findOrFail($id);
        return view('product', ['product' => $product, 'destination' => 'editProduct']);
    }

    public function store(ValidateAddProduct $request)
    {
        $newImageName = time() . '-' . $request->title . '.' . $request->image->extension();
        $request->image->move(public_path('storage/photos'), $newImageName);

        $product = new Product;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->imageSource = $newImageName;

        $product->save();

        return redirect()->back();
    }
}
