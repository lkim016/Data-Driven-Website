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

Route::get('/bootstrap', function () {
    return view('bootstrap');
});

Route::get('/bootstrapgrids', function () {
    return view('bootstrapgrids');
});

Route::get('/login2', function () {
    return view('login2');
});

Route::get('/main', function () {
    return view('main');
});

Route::get('/main10', function () {
    return view('main10');
});
Route::get('/main11', function () {
    return view('main11');
});

Route::get('/loginpage', function () {
    return view('loginpage');
});

Route::get('/main2', function() {
    return view('main2');
});
Route::get('/mainh', function() {
    return view('mainhorizontal');
});
Route::get('/mains', function() {
    return view('mainsticky');
});
Route::get('/mainr', function() {
    return view('mainresponsive');
});
Route::get('/maind', function() {
    return view('maindropdown');
});