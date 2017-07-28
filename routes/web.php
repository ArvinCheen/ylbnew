<?php


Route::get('/ss',function () {
    echo 222;exit;
    return view('layout/index');
});

Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/login', 'Auth\LoginController@index');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/register', 'Auth\LoginController@register');

Route::get('/index', 'dashboardController@index');
Route::get('/', 'dashboardController@index');

Route::get('/dashboard', 'dashboardController@index');

Route::get('/authority', 'authorityController@index');
Route::post('/insertAuthority', 'authorityController@insertAuthority');
Route::put('/updateAuthority', 'authorityController@updateAuthority');
Route::delete('/deleteAuthority', 'authorityController@deleteAuthority');

Route::get('/memberAuthority', 'authorityController@memberAuthority');
Route::post('/setMemberAuthority', 'authorityController@setMemberAuthority');


Route::get('/updateAuthority', 'authorityController@updateAuthority');

//GET: 讀取資源
//POST: 新增資源
//PUT: 替換資源
//PATCH: 更新資源部份內容
//DELETE: 刪除資源
