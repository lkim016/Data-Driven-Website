<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller {
    public function __construct (Request $request) 
    {

    }

    public function postRegister(Request $request) 
    {
        //Retrieve the username input field
        $username = $request->input('username');
        echo 'Username: '.$username;
        echo '<br>';

        //Retrieve the password input field
        $passwd = $request->passwd;
        echo 'Password: '.$passwd;
        echo '<br>';

        //Retrieve the email input field
        $email = $request->email;
        echo 'Email: '.$email;
    }

    public function insertform()
    {
        return view('/register');
    }
    public function insert(Request $request)
    {
        $username = $request->input('username');
        $passwd = $request->input('passwd');
        $email = $request->input('email');
        DB::insert('insert into users (username, passwd, email) values (?, ?, ?)',[$username, $passwd, $email]);
        echo "Record inserted successfully.<br/>";
        echo '<a href="/register">Click Here</a> to go back.';
    }
    public function view()
    {
        $users = DB::select('select * from users');
        return view('user_view', ['users'=>$users]);
    }
    public function show($id)
    {
        $users = DB::select('select * from users where id = ?',[$id]);
        return view('user_update', ['users'=>$users]);
    }
    public function edit(Request $request, $id)
    {
        $username = $request->input('username');
        $passwd = $request->input('passwd');
        $email = $request->input('email');
        DB::update('update users set username = ?, passwd = ?, email = ? where id = ?',[$username, $passwd, $email, $id]);
        echo "Record updated successfully.<br/>";
        echo '<a href="/view-users">Click Here</a> to go back.';
    }

    public function val(Request $request)
    {
        $username = $request->input('username');
        $passwd = $request->input('passwd');
        $db = mysqli_connect('localhost', 'root', 'Sprite1234!', 'cis197');
        $query = "select * from users where username='$username' and passwd = '$passwd'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
            $_SESSION['username'] = $username;
            return view('main');
        }
        else {
            echo "Wrong username/password combo";
            echo '<br/><a href="/login">Click Here</a> to go back.';
            return view('login');
        }
    }
    
    public function destroy($id)
    {
        DB::delete('delete from users where id = ?',[$id]);
        echo "Record deleted successfully.<br/>";
        echo '<a href="/view-users">Click Here</a> to go back.';
    }

}
