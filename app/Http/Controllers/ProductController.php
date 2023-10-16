<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use App\Http\Requests\ValidateAddProduct;
use App\Http\Requests\ValidateEditProduct;

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
                return view('cart', ['products' =>  $products, 'mail' => false]);
            }
        } else {
            return view('cart', ['mail' => false, 'empty' =>  trans('messages.emptyCart')]);
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

    public function deleteProductFromDB($id)
    {
        Product::where('id', $id)->delete();
        return redirect()->back();
    }

    public function update(ValidateEditProduct $request)
    {
        $title = $request->title;
        $description = $request->description;
        $price = $request->price;
        $newImageName = time() . '-' . $request->title . '.' . $request->image->extension();
        $request->image->move(public_path('storage/photos'), $newImageName);

        Product::where('id', $request->id)->update(['title' => $title, 'description' => $description, 'price' => $price, 'imageSource' => $newImageName]);

        return redirect()->route('products');
    }

    public function storeProduct(ValidateAddProduct $request)
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

    public function editProductView($id)
    {
        $product = Product::findOrFail($id);
        return view('product', ['product' => $product, 'destination' => 'editProduct']);
    }

    public function addProductView()
    {
        return view('product', ['destination' => 'addProduct']);
    }
}
