<?php

namespace Modules\Tools\Providers;

use Illuminate\Support\ServiceProvider;

//php artisan module:make-provider HuyiSmsServiceProvider Tools
class HuyiSmsServiceProvider extends ServiceProvider
{


    //接口类型：互亿无线触发短信接口，支持发送验证码短信、订单通知短信等。
// 账户注册：请通过该地址开通账户http://user.ihuyi.com/register.html
// 注意事项：
//（1）调试期间，请使用用系统默认的短信内容：您的验证码是：【变量】。请不要把验证码泄露给其他人。
//（2）请使用 APIID 及 APIKEY来调用接口，可在会员中心获取；
//（3）该代码仅供接入互亿无线短信接口参考使用，客户可根据实际需要自行编写；
//开启SESSION
//session_start();
//注意不要使用$_SESSION


    //请求数据到短信接口，检查环境是否 开启 curl init。
    private   function Post($curlPost,$url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        $return_str = curl_exec($curl);
        curl_close($curl);
        return $return_str;
    }

    //将 xml数据转换为数组格式。
    private  function xml_to_array($xml){
        $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
        if(preg_match_all($reg, $xml, $matches)){
            $count = count($matches[0]);
            for($i = 0; $i < $count; $i++){
                $subxml= $matches[2][$i];
                $key = $matches[1][$i];
                if(preg_match( $reg, $subxml )){
                    $arr[$key] =$this-> xml_to_array( $subxml );
                }else{
                    $arr[$key] = $subxml;
                }
            }
        }
        return $arr;
    }


    public function SendHuYi($mobile,$mobile_code){
        header("Content-type:text/html; charset=UTF-8");
        //短信接口地址
        $target = "http://106.ihuyi.com/webservice/sms.php?method=Submit";
        //获取验证码
        //$send_code = $_POST['send_code'];
        if(empty($mobile)){
            return "手机号码不能为空";
        }
        if(empty($mobile_code)){
            return "不能为空";
        }
        //防用户恶 意请求
        //if(empty($_SESSION['send_code']) or $send_code!=$_SESSION['send_code']){
        //    exit('请求超时，请刷新页面后重试');
        //}
        $post_data = "account=C96379888&password=f98e42d743c00ecf0243c41a179d4b85&mobile=".$mobile."&content=".rawurlencode("您的验证码是：".$mobile_code."。请不要把验证码泄露给其他人。");
        //查看用户名 登录用户中心->验证码通知短信>产品总览->API接口信息->APIID
        //查看密码 登录用户中心->验证码通知短信>产品总览->API接口信息->APIKEY
        $gets = $this-> xml_to_array( $this->Post($post_data, $target));
        if($gets['SubmitResult']['code']==2){
            // $_SESSION['mobile'] = $mobile;
            // $_SESSION['mobile_code'] = $mobile_code;
        }
        return $gets['SubmitResult']['msg'];
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
