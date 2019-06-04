<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    // MAIN
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
            $username = $db_user->username;
            $request->session()->put('user', $username);
            $login_check = $db_user->valid_login;
            $user_type = array('CIMT', 'resource provider', 'admin');
            // if yes: query the joined tables to get specific detail about the user
            if ($login_check === 1) { // what is the counter(username) = 1: does this also account for double input of the user? The db anyway has a uk constraint on username
                $user_info = DB::select("select u.username, u.disp_name AS disp_name, IFNULL(a.email, 0) AS email, IFNULL(c.phone_number, 0) AS phone, IFNULL(CONCAT(r.street_number, 
                r.street, ' ', IFNULL(r.apt_number, 'n/a'), ' ', r.city, ' ', r.state, ' ', r.zip), 0) AS address FROM `user` u LEFT JOIN `admin` a ON (u.username = a.username)
                LEFT JOIN `cert_member` c ON (u.username = c.username) LEFT JOIN `resource_provider` r ON (u.username = r.username)
                WHERE u.username = ?;", array($username));
                foreach ($user_info as $db_user_info) {
                    $request->session()->put('login_disp', $db_user_info->disp_name);
                    $request->session()->put('login_email', $db_user_info->email);
                    $request->session()->put('login_phone', $db_user_info->phone);
                    $request->session()->put('login_add', $login_address = $db_user_info->address);
                    // check user type
                    if ($db_user_info->email !== 0) {
                        $request->session()->put('user_type', $user_type[0]);
                    } else if($db_user_info->phone !== 0) {
                        $request->session()->put('user_type', $user_type[1]);
                    } else if($db_user_info->address !== 0) {
                        $request->session()->put('user_type', $user_type[2]);
                    }
                }
                return view('index');
            } else {
                return redirect()->to('/login');
            }
        }

    }

    // ADD-RESOURCE
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
        $username = $request->session()->get('user');
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
        $option = [];
        if (!empty($option)) { // need to check if secondary function has no values selected
            for ($i=0; $i < count($secondary_func); $i++) {
                $option[$i] = htmlspecialchars($secondary_func[$i]);
            }
        }
        
        // put html data into db
        // db insert statement
        DB::insert('insert into resource
        (username, resource_name, primary_function_id, description, capabilities, distance, cost, unit_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?);',
        array($username, $res_name, $primary_func, $desc, $capa, $dist, $cost, $unit)); // resource_id is auto-incremented
        
        // get resource_id from db
        $resource_id = DB::select("select max(resource_id) as id from resource;");
        foreach ($resource_id as $last_id) {
            $last_res_id = $last_id->id;
        }
        
        // html input could have mutliple for secondary_func
        if (!empty($option)) {
            for ($i=0; $i < count($option); $i++) {
                DB::insert('insert into secondary_function
                (resource_id, function_id)
                VALUES
                (?, ?);', array($last_res_id, $option[$i]));
            }
        }
        // if data has been successfully entered send message
        return redirect()->to('/main');
        // else send error message
    }

    // ADD-INCIDENT
    public function incident_load(Request $request) {
        $category_info = DB::select("select category_id, type from category");
        // need to populate add-incident drop-down with db category data
        return view('/add-incident', compact('category_info'));
    }

    public function incident_save(Request $request) {
        // get html input
        // insert into username, category_id, incident_id, date, description
        $username = $request->session()->get('user');
        $category_id = htmlspecialchars($request->input('category'));
        $date = htmlspecialchars($request->input('date'));
        $description = htmlspecialchars($request->input('description'));

        // get the previous incident_id [number]
        // need to check the edge cases: check if this is first incident input (SOLVED) input a default value, if null
        $incident_id = DB::select('select IFNULL(incident_id, "C1-0") AS id from incident order by incident_id desc limit 1');
        
        $id = '';
        foreach($incident_id as $incident) {
            $id = $incident->id;
        }

        // separate number from string
        $id_num = substr($id, 2); // slices value starting from 2 (array position)
        // generate incident id [category id]-[number]
        $incident_id = $category_id . '-' . ($id_num + 1);

        // change $date to MYSQL datetime format
        $str_to_date = strtotime($date);
        $datetime = date('Y-m-d H:i:s', $str_to_date);

        // insert values into db
        // PROBLEM: NEED TO CHANGE DATE VALUE TO DATETIME IN JS
        DB::insert('insert into incident
        (username, category_id, incident_id, date, description)
        VALUES(?, ?, ?, ?, ?);', array($username, $category_id, $incident_id, $datetime, $description));

        return redirect()->to('/add-incident');
    }

    // SEARCH RESOURCES
    public function search_load(Request $request) {
        // query db to get the primary function and secondary function
        $primary_function = DB::select('select function_id, description from function');

        $display_incident = DB::select('select incident_id, description from incident');

        return view('/search-resource', compact('primary_function', 'display_incident') );
    }

    public function search_disp(Request $request) {
        // get html input
        $key = htmlspecialchars( $request->input('keyword') );
        $function_search = htmlspecialchars( $request->input('prim_func') ); // this results in the function id
        $incident_search = htmlspecialchars( $request->input('incident') );
        $distance_search = htmlspecialchars( $request->input('distance') );
        
        // query the database with the $key
        $result = DB::table('resource as r')
        ->join('function as f', 'r.primary_function_id','=','f.function_id')
        ->join('cost_unit as cu','r.unit_id','=','cu.unit_id')
        ->join('incident as i','r.username','=','i.username')
        ->distinct()
        ->select('r.username as owner', 'r.resource_id as resource_id', 'r.resource_name as resource_name', 'r.cost as cost', 'cu.unit as unit', 'r.distance as distance')
        ->where('r.resource_name', 'LIKE', '%'.$key.'%')
        ->orWhere('r.description', 'LIKE', "%".$key."%")
        ->orWhere('r.capabilities', 'LIKE', "%".$key."%")
        ->orWhere('f.function_id', 'LIKE', "%".$function_search."%")
        ->orWhere('i.incident_id', 'LIKE', "%".$incident_search."%") // this shows up because of username
        ->orWhere('r.distance', 'LIKE', "%".$distance_search."%") // need to figure out how to filter this so that it doesn't do a search
        ->get();

        $js_result= json_encode($result, JSON_HEX_TAG);

        return response()->json($js_result, 200 );
    }

    // GENERATE RESOURCE REPORT
    public function show_resource (Request $request) {
        $username = $request->session()->get('user');
        
        // need to get the all primary_function_id, description, total resources
        $html_report = DB::select("select tf.function_id AS 'function_id', description AS 'function_desc',
        IFNULL(total.total_resources, 0) AS 'total_resource' FROM function tf
        LEFT JOIN(SELECT f.function_id, COUNT(r.primary_function_id) AS 'total_resources'
        FROM `function` f LEFT OUTER JOIN `resource` r ON (f.function_id = r.primary_function_id)
        WHERE username = ? GROUP BY f.function_id WITH ROLLUP) AS total ON (tf.function_id = total.function_id) ORDER BY tf.function_id;", array($username));

        // calculate sum of total resource
        $sum = 0;
        foreach($html_report as $total) {
            $sum += $total->total_resource;
        }
        return view('/resource-report', compact('html_report', 'sum') );
    }
}