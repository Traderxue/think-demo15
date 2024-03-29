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
use think\facade\Route;

Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});

Route::get('hello/:name', 'index/hello');


Route::group("/user",function(){

    Route::post("/login","user/login");

    Route::post("/register","user/register");

});

Route::group("/user",function(){

    Route::post("/edit","user/edit");

});

Route::group("/type",function(){

    Route::post("/add","type/add");

    Route::post("/edit","type/edit");

    Route::delete("/delete/:id","type/deleteById");

    Route::get("/getall/:u_id","type/getAll");

    Route::get("/getrun/:u_id","type/getRun");

    Route::get("/price/:type","type/getPrice");

});