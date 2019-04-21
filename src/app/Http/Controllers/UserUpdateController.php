<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserUpdateController extends Controller
{
    public function index()
    {
        $users = DB::select('select * from test');
        return view('user_edit_view',['users'=>$users]);
    }
    public function show($id)
    {
        $users = DB::select('select * from test where id = ?',[$id]);
        return view('user_update',['users'=>$users]);
    }
    public function edit(Request $request,$id)
    {
        $name = $request->input('username');
        DB::update('update test set name = ? where id = ?',[$name,$id]);
        echo "Record updated successfully.<br/>";
        echo '<a href = "/edit-records">Click Here</a> to go back.';
    }
}
