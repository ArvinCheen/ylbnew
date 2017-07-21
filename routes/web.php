<?php


//Route::get('/',function () {
//    return view('layout/index');
//});

Route::get('/login','Auth\LoginController@index');

Route::get('/','indexController@index');


