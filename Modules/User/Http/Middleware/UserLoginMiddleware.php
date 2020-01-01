<?php

namespace Modules\User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\User;
class UserLoginMiddleware
{
    /**
     * php artisan module:make-middleware UserLoginMiddleware User
     * 中间件
     * 确保用户已经登陆
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * 注册地点 app\Http\Kernel.php
     * 注册名称 userlogin
     */
    public function handle(Request $request, Closure $next)
    {
        //return $next($request);
        $id=$request->post("id");
        $guid=$request->post("guid");
        if($id&&$guid&&(User::where("id",$id)->where("token",$guid)->exists())){
            return $next($request);
        }else{
            $res = fail("请登陆!") ;
            $res = json_encode($res);
            exit($res);
              //exit("NO AUTH!"); //本处如果使用return 字符串 会报错,
        }




    }
}
