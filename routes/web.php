<?php


Route::get('/ss',function () {
    echo 222;exit;
    return view('layout/index');
});

Route::get('/index', 'indexController@index')->middleware('auth');

Route::get('/login', 'Auth\LoginController@index');

Route::post('/login', 'Auth\LoginController@login');
Route::post('/register', 'Auth\LoginController@register');
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/fastRegister', 'Auth\LoginController@fastRegister');
Route::get('/fastLogin', 'Auth\LoginController@fastLogin');
