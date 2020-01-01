<?php

namespace Modules\Tools\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\User;
use Modules\Tools\Entities\TCheck ;
use Modules\Tools\Entities\Message;
class MsgController extends Controller
{


    public  function  SendMSG(Request $request){
        $appkey = $request->post("appkey");
        if( !$appkey||!TCheck::where("appkey",$appkey)->exists()) return fail("无权访问!");
    //    $id = $request->post("id");$token = $request->post("guid");
//        if($id||$token||User::where("id",$id)->where("token",$token)->exists()){
//            $uid = $id ;
//        }else{
//            $uid = 0 ;
//        }
        $uid = 0 ;
        $att = $request->post("att"); //接收人
        //这里混杂了是否已登录的情况,最好还是分开写
//        if($att==$att-0){
//            //是一个数字
//            $attid=$att;
//            $att = '';
//        }else{
//            $attid=-1;
//            // $att = '';
//            //是一个appkey
//        }
        $attid=0;
        $text = $request->post("text");
        $img = $request->post("img");
        if(!$img)$img= '';
        if(!$text&&!$img){
            return fail("不能发送空内容");
        }
       $created_at =  date_create(null,timezone_open("Asia/Shanghai"));
        $res =  Message::insert(["send"=>$appkey,"sendid"=>$uid,"att"=>$att,"attid"=>$attid,"text"=>$text,"img"=>$img,"created_at"=>$created_at]); //read 默认为 0
        return result($res);
    }

    public function AutoMSG($msg){
       //
    }

    public function GetLastMSG(Request $request){
        $appkey = $request->post("appkey");
        if( !$appkey||!TCheck::where("appkey",$appkey)->exists()) return fail("无权访问!");
 //       $id = $request->post("id");$token = $request->post("guid");
//        if ($id || $token || User::where("id", $id)->where("token", $token)->exists()) {
//            //按ID查询
//            $res = Message::  orWhere(function ($q) use ($id) {
//                $q->where("sendid", $id)->where("attid", $id);
//            })->get();
//           // exit("id_c");
//        } else {
//            //exit("app_c");
//            //按IDappkey查询
//            $res = Message:: where("send", $appkey) -> orWhere("att", $appkey)->get();
//        }
        $res = Message:: where("send", $appkey) -> orWhere("att", $appkey)->get();
        return result($res);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('tools::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('tools::create');
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
        return view('tools::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('tools::edit');
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
