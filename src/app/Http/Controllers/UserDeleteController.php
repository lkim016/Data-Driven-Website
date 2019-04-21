<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserDeleteController extends Controller
{
    public function index()
    {
        $users = DB::select('select * from test');
        return view('user_delete_view',['users'=>$users]);
    }
    public function destroy($id)
    {
        DB::delete('delete from test where id = ?',[$id]);
        echo "Record deleted successfully.<br/>";
        echo '<a href="/delete-records">Click Here</a> to go back.';
    }
}
