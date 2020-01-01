<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Entities\UserAccount;
use App\Models\Config;
use Modules\User\Entities\UserLove;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;
use App\Untils\CommFunction;

//账目类操作,必须存在访问权限才能访问
class AccountController extends Controller
{



    //提现
    public function GetAchieves(Request $request){
        $id = $request->post("id");
        $change = $request->post("change");
        $remark = $request->post("remark");
        if($remark!="申请") return fail("您暂时无法兑换!");
        $remark = "审核中";
        if($change<0.01) return fail("提现金额太低");
        $UserAccount = UserAccount::where("id",$id)->first();
        if(!$UserAccount||$UserAccount["achieves"]-$change<0) return fail("账户金额不足");
        return    CommFunction::ChangeAcc($id,-1*$change,"achieves","兑换","",$remark);
    }
    //專用于智慧点转成就点
    public function  HChange(Request $request){
        $id = $request->post("id");
        $change = $request->post("change")-0;
        $remark = $request->post("remark");

        if($change<0.01) return fail("转换金额太低");
        $UserAccount = UserAccount::where("id",$id)->first();
        if(!$UserAccount||$UserAccount["wits"]-$change<0)return fail("智慧点不足");
        if(!$remark) $remark = '转换';
         $res =   CommFunction::ChangeAcc($id,-1*$change,"wits","成就增加","",$remark);
        $change = $change *0.01 ;
         if($res["status"]) return CommFunction::ChangeAcc($id,$change,"achieves","成就增加","",$remark);
         return fail();
    }


    public function Sign(Request $request){
        $id = $request->post("id");
        //先检查今天是否已经签到
         if(UserLove::where("uid",$id)->where("type","签到")
             ->whereDate('created_at', date_create(null, timezone_open("Asia/Shanghai")))->exists())
             return fail("今日已签到");
       // $change = $request->post("change");
      //  $remark = $request->post("remark");
      //  if($change<0.01) return fail("提现金额太低");
       // $UserAccount = UserAccount::where("id",$id)->first();
       // if(!$UserAccount) return fail("账户金额不足");

        $release =Config::where("keys","release") ->first();
        if($release)$release=$release["value"];else  return fail("签到失败!E0");
        $UserAccount = UserAccount::where("id",$id)->first();
        if(!$UserAccount) $release =0 ;else $release =$UserAccount["love"]*$release ;
        if($release<0.01)$release=0;
        //先拨出金额
        //1 减少爱心点
        CommFunction::ChangeAcc($id,-1*$release,"love","提升智慧");
          //增加智慧点
        CommFunction::ChangeAcc($id,$release,"wits","提升智慧");
          //再增加签到奖励
          $sign =Config::where("keys","sign")->first();
          if($sign)$sign=$sign["value"];else  return fail("签到失败!E1");
          $res =  CommFunction::ChangeAcc($id,$sign,"love","签到");
          if($res["status"]){
              $release =  round($release,2);
              if($release>0) $release = "\n\r智慧✨+$release"; else $release ="";
              return msg("爱心💗+$sign $release");
          }else{
              return fail("签到异常");
          }

    }

    public function GetAccList(Request $request){
       // return 123;
        $id=$request->post("id");
        $key=$request->post("key");
       // $page=$request->post("page");
        if(!$key)return fail("field Must");
        //if(!$page)$page = 1;
        //$page
        $data=   DB::table("user_$key")->where("uid",$id)->orderBy("id","desc")->paginate(15);
        if($data) return success($data);
        return fail("加载完毕!");
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
