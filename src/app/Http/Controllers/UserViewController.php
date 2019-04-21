<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requsts;
use App\Http\Controllers\Controller;

class UserViewController extends Controller
{
    public function index() 
    {
        $users = DB::select('select * from test');
        return view('user_view', ['users'=>$users]);
    }
}
