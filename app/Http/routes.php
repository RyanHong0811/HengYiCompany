<?php

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