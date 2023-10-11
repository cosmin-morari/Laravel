<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Http\Requests\AdminAuthorization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function viewLogin()
    {
        return view('login');
    }

    public function validateLogin(Request  $request)
    {
        // $adminEmail = $request->input('adminMail');
        // $adminPassword = $request->input('adminPassword');
        
        // // if (Auth::attempt(['email' => $adminEmail, 'password' => $adminPassword])) {
        // //     // return redirect('cart');
        // //     dd('succes');
        // // } else {
        // //     dd('error');
        // // }

        // $credentials = $request->validate([
        //     'emasil' => ['required', 'email'],
        //     'password' => ['required'],
        // ]);
 
        // if (Auth::attempt($credentials)) {
        //     $request->session()->regenerate();
 
        //     return redirect()->intended('cart');
        // }
    }
}
