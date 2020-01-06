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
Route::get('/', function () {
    return view('welcome');
});

 
Route::get('/test/xml','Test\TestController@xmlTest');
 
 



 //微信开发
 
Route::get('/phpinfo',function(){
	phpinfo();
});

Route::get('/weixin','WX\WXController@wx');
Route::post('/wx','WX\WXController@receiv');
Route::get('/wx/menu','WX\WXController@createMenu');        //创建菜单
Route::get('/vote','VoteController@index');


//支付
Route::get('/test/pay','TestController@alipay');        
Route::get('/test/alipay/return','Alipay\PayController@aliReturn');
Route::post('/test/alipay/notify','Alipay\PayController@notify');



//接口
Route::get('/api/test','Api\TestController@test');


Route::post('/api/user/reg','Api\TestController@reg');         //用户注册
Route::post('/api/user/login','Api\TestController@login');     //用户登录
Route::get('/api/user/list','Api\TestController@userList')->middleware('fileter');     //用户列表
Route::get('/api/aa','Api\TestController@aa');
Route::get('/api/dec','Api\TestController@dec');
