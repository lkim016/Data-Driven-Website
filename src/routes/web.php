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
    return view('main');
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