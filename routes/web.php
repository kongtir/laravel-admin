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
    //Header("Location:/index.html"); exit();
     return view('welcome');
});
//Route::get('admin/index/index', 'Admin\IndexController@index');
/**
Route::get('admin/article/index', 'Admin\ArticleController@index');
Route::get('admin/article/create', 'Admin\ArticleController@create');
Route::post('admin/article/store', 'Admin\ArticleController@store');
 */
/**
// Admin 模块
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'admin.auth'], function () {
// 文章管理
Route::group(['prefix' => 'article'], function () {
// 文章列表
Route::get('index', 'ArticleController@index');
// 发布文章
Route::get('create', 'ArticleController@create');
// ...
});

// 分类管理
Route::group(['prefix' => 'category'], function () {
// 分类列表
Route::get('index', 'CategoryController@index');
// 添加分类
Route::get('create', 'CategoryController@create');
});
});
 *上面代码中的 namespace 就是相对于 app/Http/Controllers 的命名空间；
路径为 app/Http/Controllers/Admin 的admin模块的 namespace 就是Admin了；
prefix 就是定义 url 中模块和控制器的名字了；
 * */
// Home模块下 三级模式
Route::group(['namespace' => 'Home', 'prefix' => 'home'], function () {
    Route::group(['prefix' => 'index'], function () {
        ///home/index/index/1?name=白俊遥
        Route::get('index/{id}', 'IndexController@index');
    });
});

Route::get("sql/{model}", function($model) {
 // return  DB::table("$model")->take(5000) ->toArray();
});
