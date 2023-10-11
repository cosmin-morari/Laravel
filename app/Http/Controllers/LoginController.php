<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controller;
use App\Http\Requests\AdminAuthorization;
class LoginController extends Controller
{
    public function viewLogin()
    {
        return view('login');
    }

    public function validateLogin(AdminAuthorization $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        
        return redirect()->back();
    }
}
