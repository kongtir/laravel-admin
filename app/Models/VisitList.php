<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitList extends Model
{
     public function add($data,IpInfo $IpInfo,LinkInfo $LinkInfo,BrowserInfo $BrowserInfo){

         $datac["ip_id"]=$IpInfo->add($data);
         $datac["link_id"]=$LinkInfo->add($data);
         $datac["browser_id"]=$BrowserInfo->add($data);
         $datac["visitortime"]=$data["time"];
         $datac["speed"]=$data["download_speed"];
         $datac["speed"] = str_replace("undefined","?", $datac["speed"]);
         //$datac["created_at"] = date_create( null,timezone_open("Asia/Shanghai"));
        // date_timestamp_set($datac["created_at"],time());// $datac["created_at"]=time();
         // $datac["created_at"]=time();
         VisitList::insert($datac);

//         $table->string('speed',50)->default("")->comment("下载速度");
//         $table->bigInteger('ip_id')->default(0)->comment("对应ip地址");
//         $table->bigInteger('link_id')->default(0)->comment("对应link地址");
//         $table->bigInteger('browser_id')->default(0)->comment("对应浏览器地址");
//         $table->integer('visitortime')->default(0)->comment("访问者时间");

     }


    public function LinkInfo()
    {
        return $this->hasOne(LinkInfo::class,"id","link_id");
    }

    public function IpInfo()
    {
        return $this->hasOne(IpInfo::class,"id","ip_id");
    }

    public function BrowserInfo()
    {
        return $this->hasOne(BrowserInfo::class,"id","browser_id");
    }


}
