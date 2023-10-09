<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        $products = Product::all();
        return view('index', ['allProducts' => $products]);
    }

    public function cart(){
        return view('cart');
    }

    public function store(Product $product){
        
    }
}
