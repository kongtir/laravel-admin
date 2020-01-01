<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Tools\Entities\TCheck;
use Modules\User\Entities\UserDetail;
use App\User;
use Ramsey\Uuid\Uuid;
use Modules\User\Entities\UserAccount;
use Modules\User\Entities\UserTeam;
//无需登陆权限即可使用
class UserController extends Controller
{


    //登陆或者注册
    public function  Login(Request $request){
        $appkey =$request->post("appkey");
        $phone=$request->post("phone");
        $yzmsms=$request->post("yzmsms");
        //检查用户是否存在
        if(!$yzmsms||!$phone||!$appkey){
           return fail("操作异常E19");
        }
        $data =   TCheck::where("appkey",$appkey)->first();
        if(!$data){
            return fail("登陆失败E23");
        }
        //var_dump($yzmcheck,$yzmsms,$yzmcheck!=$yzmsms);exit();
        if(time()-$data["smstime"]>120||$data["smscode"]<=0||$data["smscode"]!=$yzmsms){
            return fail("验证码错误或失效!");
        }
        $date_member=  User::where("phone",$phone)->first();
        $guid =  Uuid::uuid4().Uuid::uuid4();
        if($date_member){
            //存在
            if($date_member['status']==0){
                return fail("服务异常E42!");
            }else{
                User::where("id",$date_member["id"])->update(["token"=>$guid,"last"=>time()]);
                $res["id"]=$date_member["id"];
                $res["phone"]=$phone;
                $res["name"]=$date_member["name"];
                $res["guid"]=$guid;
                return success($res);
            }
        }else{
            $sjid=User::where("phone",$request->post("yaoqing"))->get();
            if(!$sjid)$sjid = 0 ; else $sjid = $sjid["id"] ;

            $id=User::insertGetId(["name"=>$phone,"token"=>$guid,"last"=>time(),"phone"=>$phone,"sjid"=>$sjid,"email"=>time()."@NOEMAIL"]);
            //每注册一次,给当前设备+1,10次后所有新用户设备码无效. E23456
            //同一IP连续注册10次,间隔小于一定时间 等等
            //将验证码设为无效
            $res["id"]=$id;
            $res["phone"]=$phone;
            $res["name"]=$phone;
            $res["guid"]=$guid;

            return success($res);
        }
        //不存在则创建
        //初始状态为无效状态
    }


    public function getUserInfo(Request $request){
        //$phone = $request->post("phone");
        $guid = $request->post("guid");
        //$appkey = $request->post("appkey");
        $id = $request->post("id");
        $data =   User::where("id",$id)->where("token",$guid)->first();
        if(!$data) return fail("不存在该账户");
        $res["id"]=$data["id"];
        $res["phone"]=$data["phone"];
        $res["name"]=$data["name"];
        $res["guid"]=$data["token"];

        $res["account"] =UserAccount::where("id",$id)->first();

        return success($res);
    }

    /**
     * 获取团队列表,无需权限
     */
    public function  GetTeam(){
      //  return 123;
       $data= UserTeam::orderBy("sep","asc")->get();
       return result($data);
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
