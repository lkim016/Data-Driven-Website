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

Route::get('/register', function() {
    return view('register');
});

Route::post('/user/register', array('uses'=>'UserRegistration@postRegister'));

Route::get('insert', 'UserInsertController@insertform');
Route::post('create','UserInsertController@insert');

Route::get('view-records', 'UserViewController@index');

Route::get('edit-records', 'UserUpdateController@index');
Route::get('edit/{id}', 'UserUpdateController@show');
Route::post('edit/{id}', 'UserUpdateController@edit');

Route::get('delete-records','UserDeleteController@index');
Route::get('delete/{id}', 'UserDeleteController@destroy');

Route::get('sendbasicemail', 'MailController@basic_email');
Route::get('sendhtmlemail', 'MailController@html_email');
Route::get('sendattachmentemail', 'MailController@attachment_email');