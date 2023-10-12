<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
class AdminController extends Controller
{
    public function productsView(){
        
        if(session('admin')){
            return view('products');
        }else{
            return redirect()->route('login');
        }
    }

    public function logoutAdmin(){
        session()->forget('admin');
        return redirect()->route('login');
    }
}
