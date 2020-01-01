<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('user/login', 'UserController@Login');
Route::post('user/GetTeam', 'UserController@GetTeam');
Route::post('getUserInfo', 'UserController@getUserInfo');



Route::group(['middleware'=>['userlogin']],function(){
    //Route::get('/', function () {return view('welcome', ['website' => 'Laravel']);});
    //Route::view('/view', 'welcome', ['website' => 'Laravel学院']);
    Route::post('user/UpdateUserDetail', 'PostController@UpdateUserDetail');
    Route::post('user/GetMyDetail', 'PostController@GetMyDetail');
    Route::post('user/sign', 'AccountController@Sign');

    Route::post('user/GetAccList', 'AccountController@GetAccList');
    Route::post('user/GetAchieves', 'AccountController@GetAchieves');//账户提现
    Route::post('user/HChange', 'AccountController@HChange');//账户转换
});