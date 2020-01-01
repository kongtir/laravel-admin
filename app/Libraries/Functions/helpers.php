<?php
/**
 *
 * 首先是最简单粗暴的方式；
 * 手动创建 app/Libraries/Functions/helpers.php文件 ;
 * 把函数写在 helpers.php 中；
 * 在入口文件中 public/index.php 的顶部直接引入即可；
 *
 * require __DIR__.'/../app/Libraries/Functions/helpers.php';
 * =========================================================================
 * 上面这种方式简单是简单了但是过于粗暴；
 * 直接把 laravel 引以为傲的优雅拉到城乡结合部发廊的水平；
 * 不可取；不可取；
 * 那咱来个优雅的方式；
 * 先用命令行创建一个服务提供者；
 *
 * php artisan make:provider HelperServiceProvider
 *
 * 然后我们在 register 中引入函数文件；
 *
 * /**
 * Register the application services.
 *
 * @return void
 *
 * public function register()
 * {
 * require app_path().'/Libraries/Functions/helpers.php';
 * }
 *
 *
 * 最后在 config/app.php 文件中的 providers 数组中注册提供者；
 *
 * 'providers' => [
 * // 此处省略无数 ServiceProvider ...
 * App\Providers\HelperServiceProvider::class,
 * ],
 * =========================================================================
 * 那可不可以有种方式既简单又不粗暴呢？
 * 这就要靠我们根目录下的 composer.json 文件了；
 * 在 autoload 中加上 files；
 *
 * "autoload": {
 * "classmap": [
 * "database",
 * "app/Libraries/Org"
 * ],
 * "psr-4": {
 * "App\\": "app/"
 * },
 * "files": [
 * "app/Libraries/Functions/helpers.php"
 * ]
 * },
 *
 * 然后运行下面的命令更新一下；
 *
 * composer dump-autoload
 * ok；就这么完了；
 * =======================
 * laravel 是推崇模块化开发的；
 * 第三方的包都是通过 composer 引入的；
 * 但是如果因为历史的原因或者其他情况；
 * 实在是需要引入自定义的类的；
 * 我上面其实已经讲过了；
 * 讲过了？没错；
 * 其实还是上面那段写在 composer.json 中的内容；
 * autoload 下的 classmap 增加一条 app/Libraries/Org就搞定了；;
 * 自定义的类放在 app/Libraries/Org 目录下；
 * 写好命名空间；
 * 使用的时候直接 use 就可以了；
 *
 * =======
 * laravel 也是有一个dump 函数的；
 * 这个打印出来就漂亮多了；
 */
/** 下面的函数变成插件了

https://baijunyao.com/article/152
composer require baijunyao/laravel-print

//p函数是copy https://baijunyao.com/article/123 白俊遥博客  的
if (!function_exists('p')) {
// 传递数据以易于阅读的样式格式化后输出
    function p($data, $toArray = true)
    {
// 定义样式
        $str = '<pre style="display: block;padding: 9.5px;margin: 44px 0 0 0;font-size: 13px;line-height: 1.42857;color: #333;word-break: break-all;word-wrap: break-word;background-color: #F5F5F5;border: 1px solid #CCC;border-radius: 4px;">';
        // 如果是 boolean 或者 null 直接显示文字；否则 print
        if (is_bool($data)) {
            $show_data = $data ? 'true' : 'false';
        } elseif (is_null($data)) {
            // 如果是null 直接显示null
            $show_data = 'null';
        } elseif (is_object($data) && in_array(get_parent_class($data), ['Illuminate\Support\Collection', 'App\Models\Base']) && $toArray) {
            // 把一些集合转成数组形式来查看
            $data_array = $data->toArray();
            $show_data = '这是被转成数组的Collection:<br>' . print_r($data_array, true);
        } elseif (is_object($data) && in_array(get_class($data), ['Maatwebsite\Excel\Readers\LaravelExcelReader']) && $toArray) {
            // 把一些集合转成数组形式来查看
            $data_array = $data->toArray();
            $show_data = '这是被转成数组的Collection:<br>' . print_r($data_array, true);
        } elseif (is_object($data) && in_array(get_class($data), ['Illuminate\Database\Eloquent\Builder'])) {
            // 直接调用dd 查看
            dd($data);
        } else {
            $show_data = print_r($data, true);
        }
        $str .= $show_data;
        $str .= '</pre>';
        echo $str;
    }
}

//这个也是
if (!function_exists('pd')) {
// 传递数据以易于阅读的样式格式化后输出并终止
    function pd($data, $toArray = true)
    {
        p($data, $toArray);
        die;
    }
}
 *  */
//过滤sql
if (!function_exists('clearsql')) {

    function clearsql($data)
    {
        $arr =[";",">",'<','=',"select",'into','update','delete','drop','create','insert','TRUNCATE','"',"'"];
        foreach($arr as $val) {

            $data =str_ireplace($val,'',$data);
                //dump($val);
        }
       // exit();
        return $data;
    }
}

if (!function_exists('msg')) {
    function msg($msg="OK")
    { //返回提示
        $res["data"] = null;
        $res["msg"] = $msg;
        $res["status"] = 1;
        return $res;
    }
}

if (!function_exists('fail')) {
    function fail($msg="执行失败!",$data=null)
    {   //返回失败提示
        $res["data"] = $data;
        $res["msg"] = $msg;
        $res["status"] = 0;
        return $res;
    }
}

if (!function_exists('success')) {
    function success($data,$msg="成功!")
    {   //返回成功结果
        $res["data"] = $data;
        $res["msg"] = $msg;
        $res["status"] = 1;
        return $res;
    }
}


if (!function_exists('result')) {
    function result($data)
    {   //返回成功结果
        if($data) return success($data);
        return fail();
    }
}