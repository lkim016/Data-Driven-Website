<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    // added 5/21
    public function val_login(Request $request)
    {
        // gets data from HTML
        $html_user = $request->input('username'); // query view and return data
        $html_pass = $request->input('password');
        // gets data from DB
        $user_info = DB::select('select username, disp_name, count(username) = 1 AS valid_login from USER where username = ? and password = ? group by disp_name;', array($html_user, $html_pass)); // query db and return value
        
        foreach ($user_info as $db_user) {
            $login_user = $db_user->username;
            $login_check = $db_user->valid_login;
            $login_disp_name = $db_user->disp_name;
            if ($login_check == 1){ // what is the counter(username) = 1: does this also account for double input of the user? The db anyway has a uk constraint on username

                return view('/main', compact('login_disp_name', 'login_user'));
            } else {
                // error messages
                return view('/login');
            }
        }

    }
}
