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
    return view('index');
});

// added 5/21
Route::post('/main', 'LoginController@val_login');

Route::get('/add-resource', function () {
    return view('add-resource');
});

Route::get('/add-incident', function () {
    return view('add-incident');
});

Route::get('/search-resource', function () {
    return view('search-resource');
});

Route::get('/resource-report', function () {
    return view('resource-report');
});

// Route::get('/register', function() {
//     return view('register');
// });

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