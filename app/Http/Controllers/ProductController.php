<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use App\Http\Requests\ValidateAddProduct;
use App\Http\Requests\ValidateQuantity;
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
        $cartQuantity = session()->get('cartQuantity');
        if ($cartSession) {
            $products = Product::whereIn('id', $cartSession)->get();

            if ($products) {
                return view('cart', ['products' =>  $products, 'mail' => false, 'cartQuantity' => $cartQuantity]);
            }
        } else {
            return view('cart', ['mail' => false, 'empty' =>  trans('messages.emptyCart')]);
        }
    }
    public function store(ValidateQuantity $request, $id)
    {
        $quantity = $request->input('quantity');
        $product = Product::findOrFail($id);
        $totalQuantity = $product->quantity;

        if ($quantity > $totalQuantity) {
            return redirect()->back()->with('error' . $id, trans('messages.insufficientStock'));
        }

        if ($product) {
            if (!in_array($product->id, session('cart') ?? [])) {
                session()->push('cart', $product->id);
                session()->push('cartQuantity', [$product->id => $quantity]);
            }
        }
        return redirect()->back();
    }
    public function deleteUpdateProductFromCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if ($request->input('delete')) {
            $cartSession = session()->get('cart');
            $index = array_search($id, $cartSession);
            session()->forget("cart.$index");
            session()->forget("cartQuantity.$index");
        }

        if ($request->input('update')) {
            $valueInput = $request->input('quantity');

            if (session()->has('cartQuantity')) {
                $cartQuantity = session()->get('cartQuantity');
            
                foreach ($cartQuantity as $quantity => $value){
                    $cartQuantity[$quantity ]= $valueInput;
                    // $quantity[$id]= $valueInput;
                }
                                
                
            
            }
        }
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
