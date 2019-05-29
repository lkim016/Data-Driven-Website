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
        $html_user = htmlspecialchars($request->input('username')); // query view and return data
        $html_pass = htmlspecialchars($request->input('password'));
        // gets data from DB
        $user_check = DB::select('select username, count(username) = 1 AS valid_login from USER where username = ? and password = ? group by username;', array($html_user, $html_pass)); // query db and return value
        // NEED LOGIC TO VALIDATE USERNAME AND PASS AGAINST DB
        foreach ($user_check as $db_user) {
            // check to see that the client input login is in the database
            $user = $db_user->username;
            $request->session()->put('user', $user);
            $login_check = $db_user->valid_login;
            // if yes: query the joined tables to get specific detail about the user
            if ($login_check == 1) { // what is the counter(username) = 1: does this also account for double input of the user? The db anyway has a uk constraint on username
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

    public function resource_load(Request $request)
    {
        // query db to get the primary function and secondary function
        $primary_function = DB::select('select function_id, description from function');
        // change list of functions from db to JSON to load html
        $js_func = json_encode($primary_function, JSON_HEX_TAG);

        // query the db to get the cost_unit
        $cost_unit = DB::select('select unit_id, unit from cost_unit');
        return view('/add-resource', compact('primary_function', 'js_func', 'cost_unit'));
    }

    public function resource_save(Request $request)
    {
        // resource id generates after data has been validated and saves
        // get data from html input and run html inputs through htmlspecialchars()
        $user = htmlspecialchars($request->session()->get('user'));
        $res_name = htmlspecialchars($request->input('resource_name'));
        $primary_func = htmlspecialchars($request->input('prim_func'));
        $secondary_func = $request->input('sec_func'); // optional: this is an array, need to run it through htmlspecialchars()
        $desc = htmlspecialchars($request->input('description')); // optional
        $capa = htmlspecialchars($request->input('capa')); // optional: need to have capabilites added when button clicked
        $dist = htmlspecialchars($request->input('distance')); // optional
        $cost = htmlspecialchars($request->input('cost'));
        $unit = htmlspecialchars($request->input('unit'));

        // change value of distance to db allowable value
        if ($dist == '') {
            $dist = 0;
        }
        
        // loop secondary function through htmlspecialchars()
        $option = $secondary_func;
        for ($i=0; $i < count($option); $i++) {
            $option[$i] = htmlspecialchars($option[$i]);
        }
        
        // put html data into db
        // db insert statement
        DB::insert('insert into resource
        (username, resource_name, primary_function_id, description, capabilities, distance, cost, unit_id)
        VALUES
        (?, ?, ?, ?, ?, ?, ?, ?);', array($user, $res_name, $primary_func, $desc, $capa, $dist, $cost, $unit)); // resource_id is auto-incremented
        
        // get resource_id from db
        $resource_id = DB::select("select max(resource_id) as id from resource;");
        foreach ($resource_id as $last_id) {
            $last_res_id = $last_id->id;
        }
        
        // html input could have mutliple for secondary_func
        for ($i=0; $i < count($option); $i++) {
            DB::insert('insert into secondary_function
            (resource_id, function_id)
            VALUES
            (?, ?);', array($last_res_id, $option[$i]));
        }
        // if data has been successfully entered send message
        return redirect()->to('/main');
        // else send error message
    }
}
