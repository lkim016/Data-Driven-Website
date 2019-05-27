<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    // added 5/21
    public function val_login(Request $request)
    {
        // gets data from HTML
        $html_user = $request->input('username'); // query view and return data
        $html_pass = $request->input('password');
        // gets data from DB
        $user_check = DB::select('select username, count(username) = 1 AS valid_login from USER where username = ? and password = ? group by username;', array($html_user, $html_pass)); // query db and return value
        // NEED LOGIC TO VALIDATE USERNAME AND PASS AGAINST DB
        foreach ($user_check as $db_user) {
            // check to see that the client input login is in the database
            $user = $db_user->username;
            $request->session()->put('user', $user);
            $login_check = $db_user->valid_login;
            // if yes: query the joined tables to get specific detail about the user
            if ($login_check == 1){ // what is the counter(username) = 1: does this also account for double input of the user? The db anyway has a uk constraint on username
                $user_info = DB::select("select u.username, u.disp_name AS disp_name, IFNULL(a.email, 0) AS email, IFNULL(c.phone_number, 0) AS phone, IFNULL(CONCAT(r.street_number, 
                r.street, ' ', IFNULL(r.apt_number, 'n/a'), ' ', r.city, ' ', r.state, ' ', r.zip), 0) AS address FROM `user` u LEFT JOIN `admin` a ON (u.username = a.username)
                LEFT JOIN `cert_member` c ON (u.username = c.username) LEFT JOIN `resource_provider` r ON (u.username = r.username)
                WHERE u.username = ?;", array($user));
                foreach ($user_info as $db_user_info) {
                    $request->session()->put('login_disp', $db_user_info->disp_name);
                    $request->session()->put('login_email', $db_user_info->email);
                    $request->session()->put('login_phone', $db_user_info->phone);
                    $request->session()->put('login_add', $login_address = $db_user_info->address);
                }
                return view('/index');
            } else {
                login_error($request);
            }
        }

    }

    public function add_resource_load(Request $request)
    {
        // need to query db to get the primary function and secondary function
        $primary_function = DB::select('select function_id, description from function');
        //foreach ($primary_function as $function) {
        //    $functions = array(
        //        'id' => $function->function_id,
        //        'description' => $function->description
        //    );
        //}
        return view('add-resource', compact('primary_function'));
    }

    public function add_resource_save(Request $request)
    {
        // resource id generates after data has been validated and saves
        // saves user in db
        // saves resource name
        // saves primary function
        // saves scondary function (optional)
        // saves description (optional)
        // saves capabilites (optional)
        // saves distance
        // saves cost
    }



}
