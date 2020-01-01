<?php use Illuminate\Http\Request;
/*|--------------------------------------------------------------------------| API Routes|--
------------------------------------------------------------------------||
Here is where you can register API routes for your application. These| routes are loaded by the RouteServiceProvider
 within a group which| is assigned the "api" middleware group. Enjoy building your API!|*/



Route::middleware('auth:api')->get('/douying', function (Request $request) {
    return $request->user();
});
Route::group(['middleware'=>['douying']],function(){
    //Route::get('/', function () {return view('welcome', ['website' => 'Laravel']);});
    //Route::view('/view', 'welcome', ['website' => 'Laravel学院']);
    Route::post('dy/{action}', 'ApiController@Post');
    Route::get('dy/{action}', 'ApiController@Get');
});
Route::get('dytool/SetMCS', 'ToolsController@SetMCS');
//Route::post('dytool/SubTask', 'ToolsController@SubTask');

// 查看数据库语句: \DB::enableQueryLog(); dd(\DB::getQueryLog());