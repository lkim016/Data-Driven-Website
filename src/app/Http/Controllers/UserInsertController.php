<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserInsertController extends Controller
{
    public function insertform() 
    {
        return view('user_create');
    }

    public function insert(Request $request)
    {
        $name = $request->input('username');
        DB::insert('insert into test (name) values(?)',[$name]);
        echo "Record inserted successfully,<br/>";
        echo '<a href="/insert">Click Here</a> to go back.';
    }
}
