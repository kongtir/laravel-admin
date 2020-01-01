<?php

namespace Modules\Douying\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Douying\Entities\DyTask;
use Modules\Douying\Entities\DyTasklist;
use Modules\Douying\Entities\DyTx;
use Modules\Douying\Entities\DyUser;
use Ramsey\Uuid\Uuid;
use Modules\Douying\Entities\DyCode;
use Modules\Douying\Entities\DyNews;
use Modules\Douying\Entities\DyConfig;
use Illuminate\Support\Facades\Storage;
//     $sxf =DyConfig::where("keys","sxf")->select(["value"])->first()["value"];
class ApiController extends Controller
{

    public function Get($action){
        header('Access-Control-Allow-Origin:*');
        switch ($action){
            case "GetTaskList": return result($this->GetTaskList()); break;
            case "GetNews": return $this->GetNews(); break;
            default: return fail("Error!");
        }

        return fail("GET".$action);
    }

    public function Post($action){
        //$action =$request->post("action");
        header('Access-Control-Allow-Origin:*');
        if(!in_array($action,["reg","Login"])){
            //检查登陆情况
            $res1["url"]="/pages/Public/login.html";
            if(!DyUser::where("appkey",$_POST['appkey'])->where("id",$_POST['userid'])->exists())
                return fail("请重新登陆!",$res1 );
        }
        //检查登陆权限E123456
        switch ($action){
            case "reg": return $this->Reg(); break;
            case "Login":return $this->Login(); break;
            case "GetTask";return  $this->GetTask();break;
            case "tg":return $this->Tg();break;
            case "GetCodes";return $this->GetCodes();break;
            case "tcm";return $this->TiXian();break;
            case "setinfo":return $this->SetInfo();break;
            case "setinfo":return $this->SetInfo();break;
            case "GetMCList":return $this->GetMCList();break;
            case "psd":return $this->ChangePSD();break;
            case "GetOneTask":return $this->GetOneTask();break;
            case "SubTask":return $this->SubTask();break;
            case "TuanDui":return $this->TuanDui();break;
            default: return fail("Error!");
        }
        return fail("Post".$action);
    }
    private  function  GetTaskList(){
        return DyTask::where("status",1)->orderBy('id', 'DESC')->limit(200)
            ->select("id",'types','mark',"maxreward","nickname",'total','balance','top',"url")
            ->get();
    }
    private function  Reg(){
        $username =  $_POST['username'];
        $yaoqingren =  $_POST['invite_code'];
        $password =  $_POST['password'];
        $repassword =  $_POST['repassword'];
        if(!$username||!$yaoqingren||!$password||!$repassword) return fail("请完整输入!");
        if($password!=$repassword)return fail("两次密码输入不一致!");
        if(DyUser::where("username",$username)->exists())return fail("用户名重复!");
        if(!DyUser::where("username",$yaoqingren)->exists())return fail("邀请人不存在!");
        $_now =   date_create(null,timezone_open("Asia/Shanghai")) ;//php时间
        $res= DyUser::insert(["username" => $username, "yaoqingren" => $yaoqingren, "password" => $password
            ,"edittime"=>$_now,"logintime"=>  $_now]);
        return result($res);
    }
    private function  Login(){
        $username =  $_POST['username'];
        $password =  $_POST['password'];
        $appkey =  $_POST['appkey'];
        $userid =  $_POST['userid'];
        //exit($username.$password);
        // \DB::enableQueryLog(); dd(\DB::getQueryLog());
        if(($username&&$password)) {
            if(!DyUser::where("username",$username)->exists())return fail("用户不存在!");
             $data =DyUser::where("username","=",$username)->where("password",$password)  ->select("id","username",'nickname','truename','status','alipay','leijitixian','yue','appkey','leiji')->first();

            if(!$data) return fail("账户或密码错误");
            //
            $data["appkey"]= Uuid::uuid4();
            DyUser::where("id",$data["id"])->update(["appkey"=>$data["appkey"]]);

        }else  if($userid&&$appkey) {
            $data =DyUser::where("appkey",$appkey)->where("id",$userid)
                ->select("id","username",'nickname','truename','status','alipay','leijitixian','yue','appkey','leiji')->first();
            if(!$data) return fail("id信息不完整");
        }else{
            return fail("请完整输入!");
        }

        $data0["userinfo"]=$data;
        $data1["save"]=$data0;
        $data1["url"]="../../pages/Index/index.html";
        return success($data1);
    }
    private function GetTask(){
        $doact = $_POST["doact"];
        if($doact=="add"){
            //添加任务 检查是否领取任务->已领取不在领取
            if(DyTasklist::where("taskid",$_POST["id"])->where("userid", $_POST["userid"])->exists())return success(null,"请勿重复领取");

            //检查今日的领取任务是否超过5条(释放少量任务由手工完成)
            $count= DyTasklist::whereDate('created_at',date("Y-m-d")) ->count();
            if($count>=5) return fail("");//今日已用完次数
            $user = DyUser::where("id",$_POST['userid'])->first();
            $res = DyTasklist::insert([
                "username"=>$user["username"],"userid"=>$user["id"]  ,"taskid"=> $_POST["id"],"applytime"=>time()
                ,"created_at"=> date_create(null,timezone_open("Asia/Shanghai"))
                ]);
            return success($res,"领取成功!");
            //检查是否能够领取任务->百分比不足的不能领取
        }else if($doact=="list"){
            //最近500条任务列表
            $res =  DyTasklist::where("userid", $_POST["userid"])->orderBy("id","desc")->limit(500)->get();
            return result($res);
        }
        //领取人账户 ID  任务ID[通过详情查看] 领取时间 提交时间 (是否已关闭)  审核结果 预计到账


    }
    private  function  Tg(){
        $phone =  $_POST["phone"];
        $psd =  $_POST["psd"];
        $code =  $_POST["code"];
       // \DB::enableQueryLog();dd(\DB::getQueryLog());
        if(!$phone||!$psd||!$code)return fail("请完善输入");
        $fat = DyCode::where("used",0)->where("yishou",1)->where("phone",$phone)->
        where("psd",$psd)->where("keys",$code) -> first();
        $user = DyUser::where("id",$_POST["userid"])->first();
        if($fat){
          $res=  DyCode::where("id",$fat["id"])->update(["used"=>1,"userid"=>$_POST["userid"]
              ,"username"=>$user["username"]
                ,"usetime"=>time(),"status"=>1]);
           return  result($res);
        }
        return fail("该账户挂载失败!");
    }
    private function  GetCodes(){
        return result(DyCode::where("userid",$_POST["userid"])->get());
    }
    private function  TiXian(){
        $num = $_POST["prices"];
        $num=$num-0;
        $user = DyUser::where("id",$_POST["userid"])->first();
        if(!$user["truename"]||!$user["alipay"]) return fail("请先认证!");
        $sxf =DyConfig::where("keys","sxf")->select(["value"])->first()["value"];
        if($num<=0||$num+$sxf>$user["yue"]) return fail("额度过高!");
        $num_c =\DB::select(
            "select count(1) num from dy_txes where to_days(FROM_UNIXTIME(apply)) = to_days(now()) and userid = ?",[$user["id"]]);
        $num_c =$num_c[0]->num;
        if($num_c>0) return fail("每天只允许操作一次");
        $user["yue"] = $user["yue"] - $num - $sxf ;
        $user["leijitixian"] = $user["leijitixian"] +  $num  ;
        $user["dongjie"]= $user["dongjie"]+$num;
        //1 更新USER
        $res1 = DyUser::where("id",$_POST["userid"])->update(["yue"=>$user["yue"]
            ,"leijitixian"=>$user["leijitixian"] ,"dongjie"=>$user["dongjie"]
        ]);
        if(!$res1) return fail("系统繁忙!");
        //2 更新TX
        $res2 = DyTx::insert(["card"=> $user["alipay"],"txtype"=>"支付宝",
            "username"=>$user["username"],"amount"=>$num,
            "userid"=>$user["id"],
            "truename"=>$user["truename"],"tax"=>$sxf,"apply"=>time()]);
        if($res2)return success(true,"申请成功!");
        return fail("请稍后再试!");

    }
    private  function  SetInfo(){
        $truename = $_POST["truename"];
        $alipay= $_POST["alipay"];

        if(!$truename||!$alipay)  return fail("请完善信息");

        $user =DyUser::where("id",$_POST["userid"])->first();
        if($user["truename"]&&$user["alipay"]) return fail("不允许重复认证!");

        $res = DyUser::where("id",$_POST["userid"])->update(["truename"=>$truename,"alipay"=>$alipay]);
        if($res) return success("","认证成功!");
    }
    private function GetNews(){
        $res = DyNews::where("status",1)->get();
        return result($res);
    }
    private  function GetMCList(){
        $res = DyTx::where("userid",$_POST["userid"])->orderBy("id","desc")->get();
        return result($res);
    }
    private function ChangePSD(){
        if($_POST["password"]!=$_POST["repassword"]) return fail("两次输入不一致");
        $user = DyUser::where("id",$_POST["userid"]);
        if($_POST["old_password"]==$user["password"]){
            $res = DyUser::where("id",$_POST["userid"])->update(["password"=>$_POST["password"]]);
            if($res)  return success("","修改成功!");else return fail("修改失败");
        }else return fail("旧密码不正确");
    }
    private  function GetOneTask(){
        $userid = $_POST["userid"];
        $res = DyTasklist::where("taskid", $_POST["taskid"])
            ->where("userid", $_POST["userid"])->first();
        return result($res);
    }
    private  function SubTask(){
       $taskid = $_POST["taskid"];
       //检查是否是待提交任务
        if(!DyTasklist::where("taskid",$taskid)->where("status","等待提交")->exists()) return fail("该任务无法提交!");
        //会储存到别的地方下面
        $path = "/dy_tasks_". date('Y-m-d') ;
        $img = request()->file('file')->store($path);
        if(!$img) return fail('');
        //上传的头像字段avatar是文件类型
        $img2 = Storage::url($img);//就是很简单的一个步骤
       $res = DyTasklist::where("taskid",$taskid)->update(["subtime"=>time(),"status"=>"审核中","mark"=>$img]);
       if($res){
           return success($img,"任务提交成功,请等待审核!");
       }
       return fail("提交失败!");
    }
    private function TuanDui(){
       $res=[];
       $user = DyUser::where("id",$_POST["userid"])->first();
       $res["1"]=DyUser::where("yaoqingren",$user["username"])->select("username","gongxian")->get();
       if(!$res["1"])return fail();
       $che ="";
        foreach($res["1"] as $val) {
            $che+="'{$val["username"]}',";
        }
        if($che){
            $che+="'U_Z_P_O_C_PL_PO_PO'";
            $res["2"]= \DB::select('select username,gongxian from dy_users where yaoqingren in ( ?)', [$val]);
        }

        return result($res);

    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('douying::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('douying::create');
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
        return view('douying::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('douying::edit');
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
