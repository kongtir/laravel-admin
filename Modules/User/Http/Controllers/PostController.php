<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
//php artisan module:make-controller PostController User
use Modules\User\Entities\UserDetail;
/**
 * Class PostController
 * @package Modules\User\Http\Controllers
 * 本方法所有自定义访问必须要登陆,
 * 使用中间件控制
 */
class PostController extends Controller
{

    public function UpdateUserDetail(Request $request){
        $key = $request->post("key");
        $value = $request->post("value");
        if(!$key||!$value) return fail("Must have a value!");
        $canupdate =false;
        $id=$request->post("id");
        $UserDetail = UserDetail::where("id",$id)->first();
        if(!$UserDetail){
            UserDetail::insert(["id"=>$id]);
            $UserDetail = UserDetail::where("id",$id)->first();
        }
        if(in_array($key,["truename","qq",'wechat','mail','alipay','icard'])){
             if(!$UserDetail[$key])$canupdate =true; //没有值,则允许修改
        }else if(in_array($key,['adress'])){
            $canupdate =true;
        }else{
            return fail("can't update that!");
        }
        if(!$canupdate) return fail("无法修改!");
        $res =   UserDetail::where("id",$UserDetail["id"])->update([$key=>$value]);
        $UserDetail[$key]=$value;
        if($res>0) return success($UserDetail,"修改成功");
        return fail();
        //UserDetail
    }

    public function GetMyDetail(Request $request){
        $UserDetail = UserDetail::where("id",$request->post("id"))->first();
        if($UserDetail) return success($UserDetail);
        return fail("no data");
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('user::index');
    }
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('user::create');
    }
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('user::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
