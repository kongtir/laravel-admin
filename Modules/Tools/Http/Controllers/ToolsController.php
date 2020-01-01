<?php

namespace Modules\Tools\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Tools\Providers\HuyiSmsServiceProvider;
use Modules\Tools\Providers\ImgServiceProvider;
use Ramsey\Uuid\Uuid;
use Modules\Tools\Entities\TCheck;
use Illuminate\Contracts\Foundation\Application;
use Gregwar\Captcha\CaptchaBuilder; //验证码组建  composer require gregwar/captcha
use Gregwar\Captcha\PhraseBuilder;
class ToolsController extends Controller
{


    //appkeys 客户端唯一标识
    public  function  GetAppKey(Request $request){
        $appkey = $request->post("appkey");
        if($appkey){
            //如果APPkey存在,则直接返回APPkey
            $isExist =    TCheck::where("appkey","=",$appkey)->exists();//->count();
            if($isExist) return ["appkey"=>$appkey] ;
        }
        //否则生成appkey
        $appkey = Uuid::uuid4();
       // $appkey = Uuid:: uuid5(Uuid :: NAMESPACE_DNS, ' php.net ');
        TCheck::insert(["appkey"=>$appkey]);

        return ["appkey"=>$appkey];
    }

    /**
     * url:?/GetImgCode?appkey=53753664-b7a6-404f-907b-f4ee5ed2814d
     * @param Request $request
     * @return mixed
     */
    public function GetImgCode(Request $request){
        $appkey =$request->get("appkey") ;
        if(!$appkey) return fail("Field Must!");
        $data =   TCheck::where("appkey",$appkey)->first();
        if(!$data){
            return fail("账户已过期!");
        }
        $phrase = new PhraseBuilder;
        $code = $phrase->build(4); // 设置验证码位数
        $builder = new CaptchaBuilder($code, $phrase);// 生成验证码图片的Builder对象，配置相应属性
        // 设置背景颜色
        // $builder->setBackgroundColor(220, 210, 230);$builder->setMaxAngle(25);$builder->setMaxBehindLines(0);$builder->setMaxFrontLines(0);
        $builder->build($width = 100, $height = 40, $font = null);// 可以设置图片宽高及字体
        $phrase = $builder->getPhrase(); // 获取验证码的内容
        TCheck::where("id",$data["id"])->update(["imgcode"=>$phrase,"imgtime"=>time()]);
       // \Session::flash('code', $phrase); // 把内容存入session
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output(); exit(); // 生成图片
    }

    /**
     *   //输入手机号定位
     *   //发网页定位
     * 发送短信验证码
    */
    public function SendSMS(Request $request,Application $app)
    {
        $phone = $request->get("phone");
        $appkey = $request->get("appkey");
        $imgcode = $request->get("imgcode");

        if(!$appkey||!$imgcode||!$phone){
            return fail("Field Must!");
        }
        $phone = $phone - 0;
        if($phone<10000000000){
            return fail("手机号异常");
        }
        $data =   TCheck::where("appkey",$appkey)->first();
        if(!$data){
            return fail("账户已过期!");
        }
        if(time()-$data["imgtime"]>120){ //||$data["imgtime"]==0
           return fail("验证码过期,请点击刷新");
        }
        if(time()-$data["smstime"]<120){
            return fail("请".(120-time()+$data["smstime"])."s后再发送!");
        }
        if(!strnatcasecmp($data["yzmimg"],$imgcode)){
            return fail("图形验证码不正确");
        }
        //开始发送并记录验证码
        //生成的随机数
        $mobile_code =   rand(1000, 9999);
        $smsserver = new HuyiSmsServiceProvider($app);
        $msg  =  $smsserver->SendHuYi($phone,$mobile_code);
        TCheck::where("id",$data["id"])->update(["phone"=>$phone,"smscode"=>$mobile_code,"smstime"=>time()]);//存储验证码
        if($msg) return success($msg);
        return fail($msg);
       // $this->ajaxReturn($msg);

    }

    /**
     * 发送图形验证码
     *
     */



    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('tools::index');
    }


    public function test(){
        return 1;
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
