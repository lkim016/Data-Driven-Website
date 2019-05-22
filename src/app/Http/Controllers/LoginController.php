<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    // added 5/21
    public function get_login(Request $request)
    {
        $user = $request->input('username');
        $pass = $request->input('password');
        return view('/main');
    }
    //
}
