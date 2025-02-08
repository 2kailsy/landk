<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('/','Index/index')->allowCrossDomain();
Route::get('/login','Logins/login')->allowCrossDomain();
Route::post('/login','Logins/login')->allowCrossDomain();
Route::post('/settings','Index/settings')->allowCrossDomain();
Route::post('/personal','Index/personal')->allowCrossDomain();
Route::post('/upload/:type','Index/upload')->allowCrossDomain();
Route::get('/logout','Logins/logout')->allowCrossDomain();
Route::get('/picture','Index/picture')->allowCrossDomain();
Route::post('/picture','Index/picture')->allowCrossDomain();
Route::post('/search','Index/search')->allowCrossDomain();
Route::post('/qiandao','Index/qiandao')->allowCrossDomain();
Route::post('/says','Index/says')->allowCrossDomain();
Route::post('/saysth','Index/saysth')->allowCrossDomain();
Route::post('/sayme','Index/sayme')->allowCrossDomain();
Route::post('/paper','Index/paper')->allowCrossDomain();
Route::post('/question','Index/question')->allowCrossDomain();
Route::post('/guess','Index/guess')->allowCrossDomain();
Route::post('/shop','Index/shop')->allowCrossDomain();

Route::get('/admin','admin/admin')->allowCrossDomain();
Route::post('/admin/settings','admin/settings')->allowCrossDomain();
Route::post('/admin/personal','admin/personal')->allowCrossDomain();
Route::post('/admin/picture','admin/picture')->allowCrossDomain();
Route::post('/admin/search','admin/search')->allowCrossDomain();
Route::post('/admin/sign','admin/sign')->allowCrossDomain();
Route::post('/admin/says','admin/says')->allowCrossDomain();
Route::post('/admin/saysth','admin/saysth')->allowCrossDomain();
Route::post('/admin/sayme','admin/sayme')->allowCrossDomain();
Route::post('/admin/paper','admin/paper')->allowCrossDomain();
Route::post('/admin/question','admin/question')->allowCrossDomain();
Route::post('/admin/guess','admin/guess')->allowCrossDomain();
Route::post('/admin/shop','admin/shop')->allowCrossDomain();
Route::post('/admin/system','admin/System')->allowCrossDomain();
Route::get('/check','Logins/check')->allowCrossDomain();
return [

];
