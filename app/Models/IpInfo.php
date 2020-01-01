<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpInfo extends Model
{
    //public $timestamps = true;
    //
    /**
     * 模型日期列的存储格式
     *
     * @var string
     */
   /// protected $dateFormat = 'U';


    public  function add($data){

        $datac["ip"] = $data["ip"];
        $datac["adress"] = $data["adress"];


        $result = IpInfo::where('ip','=',$datac["ip"])->select('id')->first();
        if($result){
            return $result["id"];
        }else{
            $datac["created_at"] =  date_create(null,timezone_open("Asia/Shanghai"));
            date_timestamp_set($datac["created_at"],time());
            return   IpInfo::insertGetId($datac);
        }
    }

    public function VisitList()
    {
        return $this->belongsTo(VisitList::class);
    }
}
