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

Route::get('/','index/index');
Route::get('/login','index/login');
Route::post('/login','index/login');
Route::post('/settings','index/settings');
Route::post('/personal','index/personal');
Route::post('/upload/:type','index/upload');
Route::get('/logout','index/logout');
Route::get('/picture','index/picture');
Route::post('/picture','index/picture');
Route::post('/search','index/search');
Route::post('/qiandao','index/qiandao');
Route::post('/says','index/says');
Route::post('/saysth','index/saysth');
Route::post('/sayme','index/sayme');
Route::post('/paper','index/paper');
Route::post('/question','index/question');
Route::post('/guess','index/guess');
Route::post('/shop','index/shop');

return [

];
