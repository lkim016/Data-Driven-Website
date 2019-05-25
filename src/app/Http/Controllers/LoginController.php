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
        $user_check = DB::select('select count(username) = 1 AS valid_login from USER where username = ? and password = ?;', array($html_user, $html_pass)); // query db and return value
        
        foreach ($user_check as $db_user) {
            $user = $db_user->username;
            $login_check = $db_user->valid_login;
            if ($login_check == 1){ // what is the counter(username) = 1: does this also account for double input of the user? The db anyway has a uk constraint on username
                $user_info = DB::select("select u.username, u.disp_name, a.email, c.phone_number, r.street_number, 
                r.street, IFNULL( r.apt_number, ‘ ‘), r.city, r.state, r.zip FROM `user` u LEFT JOIN `admin` a ON (u.username = a.username)
                LEFT JOIN `cert_member` c ON (u.username = c.username) LEFT JOIN `resource_provider` r ON (u.username = r.username)
                WHERE u.username = ?;", array($user));
                //$user
                $login_disp_name = $db_user->disp_name;

                return view('/main', compact('user','login_disp_name'));
            } else {
                // error messages
                return view('/login');
            }
        }

    }
}
