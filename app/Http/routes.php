<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('homepage.index', ['menu' => '']);
});

Route::get('/about', function () {
    return view('homepage.about', ['menu' => 'about']);
});

Route::get('/companies', function () {
    return view('homepage.companies', ['menu' => 'companies']);
});

Route::get('/investor', function () {
    return view('homepage.investor', ['menu' => 'investor']);
});

Route::post('/login', function (Request $request) {
    if (Auth::attempt(['username' => $request->input('username'), 'password' => $request->input('password')])) {	
        return redirect('/');
    }
    return redirect('admin/login');
    return view('homepage.investor', ['menu' => 'investor']);
});

Route::get('/user/contracts', function () {
    return view('backend.customer.contracts', ['menu' => 'contracts']);
});

Route::get('/user/announcements', function () {
    return view('backend.customer.announcements', ['menu' => 'announcements']);
});

Route::get('/user/wallet', function () {
    return view('backend.customer.wallet', ['menu' => 'wallet']);
});

Route::get('/user/profile', function () {
    return view('backend.customer.profile', ['menu' => 'profile']);
});

Route::get('/user/dashboard', function () {
    return view('backend.customer.dashboard', ['menu' => 'dashboard']);
});