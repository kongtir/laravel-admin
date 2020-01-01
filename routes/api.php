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
Route::get('vistor', 'Visit\IndexController@VisitStatistics');
Route::post('vistor', 'Visit\IndexController@VisitStatistics');

//Event::listen('illuminate.query', function($sql,$param) {
//    file_put_contents(public_path().'/sql.log',$sql.'['.print_r($param, 1).']'."\r\n",8);
//});

