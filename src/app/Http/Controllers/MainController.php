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
        if ( empty($user_check) ) {
            $request->session()->put('user', 'error');
            // need to make error message
            return view( '/login' );
        } else {
            foreach ($user_check as $db_user) {
                // check to see that the client input login is in the database
                $db_username = $db_user->username;
                $request->session()->put('user', $db_username);
                $login_check = $db_user->valid_login; // triggers login successful message
                $user_type = array('CIMT', 'resource provider', 'admin');
                // if yes: query the joined tables to get specific detail about the user
                // what is the counter(username) = 1: does this also account for double input of the user? The db anyway has a uk constraint on username
                $user_info = DB::select("select u.username, u.disp_name AS disp_name, IFNULL(a.email, 0) AS email, IFNULL(c.phone_number, 0) AS phone, IFNULL(CONCAT(r.street_number, 
                r.street, ' ', IFNULL(r.apt_number, 'n/a'), ' ', r.city, ' ', r.state, ' ', r.zip), 0) AS address FROM `user` u LEFT JOIN `admin` a ON (u.username = a.username)
                LEFT JOIN `cert_member` c ON (u.username = c.username) LEFT JOIN `resource_provider` r ON (u.username = r.username)
                WHERE u.username = ?;", array($db_username));
                foreach ($user_info as $db_user_info) {
                    // variables to format html
                    $disp_name = $this->html_format($db_user_info->disp_name); // html format for display name
                    $phone = $phone = $this->html_format($db_user_info->phone); // html format for display name;
                    // check user type and format user info for html, if needed
                    if ($db_user_info->email !== 0) {
                        $request->session()->put('type', $user_type[0]);
                    } else if($db_user_info->phone !== 0) {
                        $request->session()->put('type', $user_type[1]);
                    } else if($db_user_info->address !== 0) {
                        $request->session()->put('type', $user_type[2]);
                    }
                    // input final html data into the session
                    $request->session()->put('display', $disp_name);
                    $request->session()->put('email', $db_user_info->email);
                    $request->session()->put('phone', $phone);
                    $request->session()->put('add', $login_address = $db_user_info->address);
                }
                $login_check = json_encode($login_check, JSON_HEX_TAG);
                return view('/index', compact('login_check', 'db_username'));
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
        return redirect()->to('/add-resource');
        // else send error message
    }

    // ADD-INCIDENT
    public function incident_load(Request $request)
    {
        $category_info = DB::select("select category_id, type from category");
        // need to populate add-incident drop-down with db category data
        return view('/add-incident', compact('category_info'));
    }

    public function incident_save(Request $request)
    {
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
            if (!empty($incident->id)){
                $id = $incident->id;
            } else {
                $id = 0;
            }
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
    public function search_load(Request $request)
    {
        // query db to get the primary function and secondary function
        $primary_function = DB::select('select function_id, description from function');

        $display_incident = DB::select('select incident_id, description from incident');

        return view('/search-resource', compact('primary_function', 'display_incident') );
    }

    public function search_disp(Request $request)
    {
        // get html input
        $input = array(
            'key' => htmlspecialchars( $request->input('keyword') ),
            'function_search' => htmlspecialchars( $request->input('prim_func') ), // this results in the function id
            'incident_search' => htmlspecialchars( $request->input('incident') ),
            'distance_search' => htmlspecialchars( $request->input('distance') )
        );

        // need to form the where array and then take out the array in the conditionals
        $where = array(
            'key' => '%'.$input['key'].'%',
            'function' => '%'.$input['function_search'].'%',
            'incident' => '%'.$input['incident_search'].'%',
            'distance' => '%'.$input['distance_search'].'%'
        );

        // broken sql clauses
        $select = "select DISTINCT u.disp_name AS 'owner', r.resource_id AS 'resource_id', r.resource_name AS 'resource_name', r.cost AS 'cost', c.unit AS 'unit', r.distance AS 'distance' FROM resource r JOIN user u ON (r.username = u.username)";
        $join_cost_unit = " JOIN cost_unit c ON (r.unit_id = c.unit_id)";
        $join_incident = " JOIN incident i ON (r.username = i.username)";
        $key_where = " WHERE (r.resource_name LIKE '".$where['key']."' OR r.description LIKE '".$where['key']."' OR r.capabilities LIKE '".$where['key']."')";
        $function_where = " and (r.primary_function_id LIKE '".$where['function']."')";
        $incident_where = " and (i.incident_id LIKE '".$where['incident']."')";
        $distance_where = " and (r.distance LIKE '".$where['distance']."')";
        $order = " order by r.distance;";
        
        // query the database based off the conditions
        // PROBLEM: WHAT TO DO IN THE CASE OF DUPLICATE RESULTS AND WHAT TO DO WHEN MORE THAN ONE INPUT IS EMPTY
        // WOULD BE BETTER TO TAKE THE QUERY OUT BASED OFF OF THE CONDITION = HAVE TO MAKE THE VARIABLES EMPTY
        if (!( empty($input['key']) && empty($input['function_search']) && empty($input['incident_search']) && empty($input['distance_search']))) {
            if(empty($input['key'])) {
                $key_where = '';
            } else if (empty($input['function_search'])) {
                $function_where = '';
            } else if (empty($input['incident_search'])) {
                $incident_where = '';
            } else if (empty($input['distance_search'])) {
                $distance_where = '';
            }
            // create complete sql statement based off of the conditions
            $sql = $select . $join_cost_unit . $join_incident . $key_where . $function_where . $incident_where . $distance_where . $order;
            $result = DB::select($sql);
        } else {
            // NEEDS TO RETURN ALL RESOURCES IN DATABASE
            $sql = $select . $join_cost_unit . $order;
            $result = DB::select($sql);
        }
        
        $js_result = json_encode($result, JSON_HEX_TAG);

        return response()->json($js_result, 200);
    }

    // GENERATE RESOURCE REPORT
    public function show_resource (Request $request)
    {
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

    // OTHER FUNCTIONS
    function html_format($var)
    { // need to format street address
        $result = '';
        // need to format phone number
        if ( (int)$var !== 0 ) { // if $var is not a string with chars and returns a result from the db
            // db stores as varchar length 10
            for($i=0; $i < strlen($var); $i++) {
                if(($i+1)%3 === 0 && $i < 8){
                    $result .= $var[$i] . '-';
                    continue;
                }
                $result .= $var[$i];
            }
        } else {
            if ( strlen($var) > 1 ){ // to catch $var if the database returns 0 for phone
                // display name, username formatting
                $split = explode(" ", $var); // for the username/owner
                for($i=0; $i<count($split); $i++) {
                    $split[$i] = strtoupper( substr($split[$i], 0, 1) ) . strtolower( substr($split[$i], 1) );
                }
                $result = implode(" ", $split);
            }
        }

        return $result;
    }
}

// NOTE:
// DON'T NEED mysql_real_escape_string BC LARAVEL QUERY BUILDER IMPLEMENTS PDO