<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrowserInfo extends Model
{
    //

    public static function add($data){

        $datac["browser"] =$data["browser"];
        $datac["agent"] =$data["agent"];
        $datac["language"] =$data["language"];
        $datac["screen"] =$data["screen"];
        $datac["vendor"] =$data["vendor"];
        $datac["plugin"] =$data["plugin"];
        $datac["os"] =$data["os"];
        $datac["wechat"] =$data["wechat"]=="true";

        $result = BrowserInfo::where($datac)
            ->select('id')
            ->first();
        if($result){
            return $result["id"];
        }else{
            $datac["created_at"] =  date_create(null,timezone_open("Asia/Shanghai"));
            date_timestamp_set($datac["created_at"],time());// $datac["created_at"]=time();
            return   BrowserInfo::insertGetId($datac);
        }
    }

    public static function add2($data){


        $result = BrowserInfo::where('browser','=',$data["browser"])
            ->where('agent','=',$data["agent"])
            ->where('language','=',$data["language"])
            ->where('screen','=',$data["screen"])
            ->where('vendor','=',$data["vendor"])
            ->where('plugin','=',$data["plugin"])
            ->where('os','=',$data["os"])
            ->where('wechat','=',$data["wechat"])
            ->select('id')
            ->first();
        if($result){
            return $result;
        }else{
            $data["created_at"]=time();
            return   BrowserInfo::insertGetId($data);
        }
    }

    public function VisitList()
    {
        return $this->belongsTo(VisitList::class);
    }

}
