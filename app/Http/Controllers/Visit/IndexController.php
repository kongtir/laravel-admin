<?php

namespace App\Http\Controllers\Visit;
use DB;
use Storage;
use App\Models\IpInfo;
use App\Models\BrowserInfo;
use App\Models\LinkInfo;
use App\Models\VisitList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
class IndexController extends Controller
{
    public  function  test(){
        return 1;
    }

    public function  VisitStatistics(Request $request,VisitList $VisitList,IpInfo $IpInfo,LinkInfo $LinkInfo,BrowserInfo $BrowserInfo){

        header('Access-Control-Allow-Origin:*');
        $data["browser"] = $request ->query("browser");
        $data["agent"] =  $request ->query("userAgent");
        $data["language"]=  $request ->query("language");
        $data["screen"]=  $request ->query("screen");
        $data["vendor"]=  $request ->query("vendor");
        $data["plugin"]=  $request ->query("PluginName");
        $data["cookie"]=  $request ->query("cookie");
        $data["time"]=  $request ->query("time");
        $data["os"]=  $request ->query("OS");
        $data["wechat"]=  $request ->query("wechat");
        $data["url"]=  $request ->query("url");
        $data["canvas_id"]=  $request ->query("canvas_id");
        $data["inner_ip"]=  $request ->query("inner_ip");
        $data["ip"]=  $request ->query("ip");
       // $data["cname"]=  $request ->query("");
        $data["download_speed"]=  $request ->query("download_speed");
        $data["ip_check"] = $_SERVER['REMOTE_ADDR']; //用于验证的IP
        $data["adress"]=  $request ->query("cname");

        if(! $data["ip"]) $data["ip"]   = $data["inner_ip"];
        //if( $data["ip_check"]!=$data["ip"]&&$data["ip_check"]!=$data["inner_ip"])
            //return ["info"=>"I.E","1"=>$data["ip_check"],"2"=>$data["ip"]];
           // return  ["info"=>"I.E"];

        return  $VisitList->add($data, $IpInfo, $LinkInfo, $BrowserInfo);

    }







}
