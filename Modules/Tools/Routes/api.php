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

Route::middleware('auth:api')->get('/tools', function (Request $request) {
    return $request->user();
});
//测试内容
Route::get('ttest0', 'ToolsController@Test');


Route::post('tools/GetAppKey', 'ToolsController@GetAppKey');

Route::post('tools/SendSMS', 'ToolsController@SendSMS');
Route::post('t/GetCalList', 'CalController@GetCalList');
Route::post('t/cal/bobi', 'CalController@bobi');
Route::post('t/cal/duipeng', 'CalController@duipeng');

Route::get('NumToFather', 'CalController@NumToFather');
Route::get('GetCengForNum', 'CalController@GetCengForNum');

Route::post('chat/SendMSG', 'MsgController@SendMSG');
Route::post('chat/GetLastMSG', 'MsgController@GetLastMSG');

Route::post('t/notice/GetNotices', 'NoticeController@GetNotices');
