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

Route::get('/', 'IndexController@index');
Route::get('/home', 'IndexController@index')->name('home');

//注册
Route::get('register', "Auth\RegisterController@showRegistrationForm");
Route::post('register', "Auth\RegisterController@register")->middleware('mail');

//登录
Route::get('login', "Auth\LoginController@showLoginForm");
Route::post('login', "Auth\LoginController@login")->name('login');
Route::get('logout', "Auth\LoginController@logout");

//验证码
Route::get('captcha', "ProController@captcha");
Route::get('ck', function (){
    dump(session('checkCode'));
});


//需要登录才能访问的页面
Route::middleware('auth')->group(function (){
    //借款
Route::get('loan', "ProController@loan");
Route::post('loan', "ProController@loanPost");

//审核
Route::get('prolist', "CheckController@prolist");
Route::get('check/{pid}', "CheckController@check");
Route::post('check/{pid}', "CheckController@checkPost");

//投资
Route::get('invest/{pid}', "InvestController@invest");
Route::post('invest/{pid}', "InvestController@investPost");

//拨款
Route::get('grow', "GrowController@grow");


//我的账单
Route::get('mybill', "IndexController@mybill");
Route::get('mybid', "IndexController@mybid");
Route::get('mygrow', "IndexController@mygrow");



});







