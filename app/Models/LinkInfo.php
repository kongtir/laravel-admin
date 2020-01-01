<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkInfo extends Model
{
    //


    public  function add($data){
        $datac["url"]=$data["url"];
        $result = LinkInfo::where($datac)->select('id')->first();
        //var_dump($result);exit();
        if($result){
            return $result["id"];
        }else{
            $datac["created_at"] = date_create(null,timezone_open("Asia/Shanghai"));
            //date_timestamp_set($datac["created_at"],time());// $datac["created_at"]=time();
            return   LinkInfo::insertGetId($datac);
        }
    }

    public function VisitList()
    {
        return $this->belongsTo(VisitList::class);
    }
}
