<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SessionController extends Controller {


   public function accessSessionData(Request $request) {
      if($request->session()->has('')) {
        echo $request->session()->get('my_name');
      } else {
        echo 'No data in the session';
      }
   }
   public function storeSessionData(Request $request) {
       $user = Session::get('login_username');
       $user_info = DB::select("select u.username, u.disp_name AS disp_name, IFNULL(a.email, 0) AS email, IFNULL(c.phone_number, 0) AS phone, IFNULL(CONCAT(r.street_number, 
       r.street, ' ', IFNULL(r.apt_number, 'n/a'), ' ', r.city, ' ', r.state, ' ', r.zip), 0) AS address FROM `user` u LEFT JOIN `admin` a ON (u.username = a.username)
       LEFT JOIN `cert_member` c ON (u.username = c.username) LEFT JOIN `resource_provider` r ON (u.username = r.username)
       WHERE u.username = ?;", array($user));
       foreach ($user_info as $db_user_info) {
               Session::put('login_disp', $db_user_info->disp_name);
               //Session::put('login_email', $db_user_info->email);
               //Session::put('login_phone', $db_user_info->phone);
               //Session::put('login_add', $login_address = $db_user_info->address);
            }
   }
   public function deleteSessionData(Request $request) {
      $request->session()->forget('my_name');
      echo "Data has been removed from session.";
   }
}