<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    //
    public $mem_global = null;
    public $do_config ;
    public function _initialize()
    {

        C(setting());
        $do_config =M("config");
        if(isset($_REQUEST["uid"])&&isset($_REQUEST["apppsd"])){
            $where["uid"]=$_REQUEST["uid"];
            $where["apppsd"]=$_REQUEST["apppsd"];
            $mem_global=M("member")->where($where)->find();
        }
    }

    public function GetConfig($keys){
        return  $this->do_config->where("keys='$keys'")->field("value")->find()["value"];
    }

    //检查传入的Appkeys 如果存在则更新或获取相关值,不存在则创建相关值
    public function GetAppkeys($id,$field="",$val=""){
        if(!$id) $this->ajaxReturn("操作异常!请联系管理员");
        $do=M("appkeys");
        $where0["uuid"]=$id;
        $data=  $do->where($where0)->find();

        if(!$data){
            $data["uuid"]=$id;
            $data["firsttime"]=time();
            $data["lasttime"]=time();
            $do->add($data);
        }

        if(!$field&&!$val){
            return -38 ;
        }elseif($field&&!$val){
            /*
            //查询数据:每种验证码只允许查询一次
            //超过60s验证码无效
            if(time() - $data[$field."time"]>60){
                return -43;
            }
            */
            return $data[$field];
        }elseif($field&&$val){
            $data2[$field]=$val;
            $data2["lasttime"]=time();
            $data2[$field."time"]=$data2["lasttime"];
            $do->where($where0)->save($data2);
        }
        return true ;

    }

    public function ajaxReturn($msg="执行失败",$status=0,$data=null){
        $result["data"]=$data;
        $result["status"]=$status;
        $result["msg"]=$msg;

        exit(json_encode($result));
    }


    public function Guid(){
        return uniqid(md5(microtime(true)),true);
    }

    /**
     * 金额变动记录:不适合提现
     * $type 1:爱心点,2:智慧点,3:成就点
     * $status 待审核[执行金额变动]  已拒绝[执行金额变动]  已到账[执行金额变动]
     * 返回===true为执行成功
     * $leixin : 爱心增加:->签到    智慧增加->释放     成就增加->转移,由外部传入
     * */
    public function ChengMoeny($uid,$change,$type=1,$xjuid=0,$leixin="",$remark=""){
        if($change==0) return "金额不能为0";
        $do_member = M("member");
        $member = $do_member->find($uid);
        if(!$member) return "用户不存在";
        $do_point = M("point");
        //$k3="djcj";//冻结成就
        //额外逻辑

        switch ($type){
            case 1 : $k1="aixin";$k2="ljax" ;   break;
            case 2 : $k1="zhihui";$k2="ljzh" ; break;
            case 3 : $k1="chengjiu";$k2="ljcj" ; break;
            default:  return "金额类型不在指定的范围";
        }

        $data0["before"]=$member[$k1];
        $data0["after"]=$member[$k1]+$change ;
        $data0["type"]=$type;
        $data0["account"]=$type;
        $data0["change"]=$change;
        $data0["leixin"]=$leixin;
        $data0["remark"]=$remark;
        $data0["addtime"]=time();
        $data0["uid"]=$member["uid"];
        $data0["xjuid"]=$xjuid;

        $data1[$k1] =  $member[$k1]+$change;
        if($change>0){
            $data1[$k2] = $member[$k2]+$change;
        }
        if($do_member->where("uid='$uid'")->save($data1)){
            if($do_point->add($data0)){
                return true;
            }else{
                return "添加记录失败!";
            }
        }   else{
            return "更改金额失败!";
        }

    }




}
