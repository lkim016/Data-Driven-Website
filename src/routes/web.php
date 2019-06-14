<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', 'login');

Route::get('/login', function () {
    return view('login');
});

Route::get('/main', function () {
    $login_val = 0;
    return view('index', compact('login_val'));
});

Route::post('/main', 'MainController@val_login');

// added 5/21

Route::get('/add-resource', 'MainController@resource_load');
Route::post('/add-resource', 'MainController@resource_save');

Route::get('/add-incident', 'MainController@incident_load');
Route::post('/add-incident', 'MainController@incident_save');

Route::get('/search-resource', 'MainController@search_load');
Route::post('/search-resource', 'MainController@search_disp');

Route::get('/resource-report', 'MainController@show_resource');




// Route::get('/register', function() {
//     return view('register');
// });

/*
Route::get('view-users', 'UserController@view');

Route::get('register', 'UserController@insertform');
Route::post('user_create', 'UserController@insert');

Route::post('/user/register', array('uses'=>'UserController@postRegister'));


Route::get('edit/{id}', 'UserController@show');
Route::post('edit/{id}', 'UserController@edit');
Route::get('delete/{id}', 'UserController@destroy');



Route::get('sendbasicemail', 'MailController@basic_email');
Route::get('sendhtmlemail', 'MailController@html_email');
Route::get('sendattachmentemail', 'MailController@attachment_email');

Route::get('register2', function() {
    return view('register2');
});
// Route::post('register2', function () {
//     return;
// });
// Route::post('/create_user', 'UserController@insert');


Route::get('login2', function() {
    return view('login2');
});
*/