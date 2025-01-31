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

Route::get('/','index/index')->allowCrossDomain();
Route::get('/login','index/login')->allowCrossDomain();
Route::post('/login','index/login')->allowCrossDomain();
Route::post('/settings','index/settings')->allowCrossDomain();
Route::post('/personal','index/personal')->allowCrossDomain();
Route::post('/upload/:type','index/upload')->allowCrossDomain();
Route::get('/logout','index/logout')->allowCrossDomain();
Route::get('/picture','index/picture')->allowCrossDomain();
Route::post('/picture','index/picture')->allowCrossDomain();
Route::post('/search','index/search')->allowCrossDomain();
Route::post('/qiandao','index/qiandao')->allowCrossDomain();
Route::post('/says','index/says')->allowCrossDomain();
Route::post('/saysth','index/saysth')->allowCrossDomain();
Route::post('/sayme','index/sayme')->allowCrossDomain();
Route::post('/paper','index/paper')->allowCrossDomain();
Route::post('/question','index/question')->allowCrossDomain();
Route::post('/guess','index/guess')->allowCrossDomain();
Route::post('/shop','index/shop')->allowCrossDomain();

return [

];
