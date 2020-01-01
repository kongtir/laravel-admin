<?php
/**
 * Created by PhpStorm.
 * User: kongt
 * Date: 2019/3/24
 * Time: 21:46
 */

namespace App\Untils;
use Modules\User\Entities\UserAccount;
use Illuminate\Support\Facades\DB;
class  CommFunction
{
    /**
     * @param $uid
     * @param $key
     * @param $type
     * @param string $batch
     * @param string $remark
     * @return mixed
     * 账目变动表:只执行insert 方法
     */
  public static  function ChangeAcc($uid,$change,$key,$type,$batch="",$remark=""){
        if(!in_array($key,["love",'wits','achieves'])) return fail("No Auth.13!");
        if($change==0) return fail("change not zore!");

        $UserAccount = UserAccount::where("id",$uid)->first();
        if(!$UserAccount){
            UserAccount::insert(["id"=>$uid]);
            $UserAccount = UserAccount::where("id",$uid)->first();
        }
        $before = $UserAccount[$key];
        $after = $UserAccount[$key] + $change;
        if($change>0){
            $leiji = $UserAccount[$key."_total"] + $change ;
        }else{
            $leiji = $UserAccount[$key."_total"] ;
        }
        try {
            DB::beginTransaction();
            UserAccount::where("id", $uid)->update([$key => $after,  $key . "_total" => $leiji]);
            DB::table("user_$key")->insert(["uid" => $uid, "change" => $change, "before" => $before,
                "after" => $after, "type" => $type, "remark" => $remark, "batch" => $batch

                , "created_at" => date_create(null, timezone_open("Asia/Shanghai"))
            ]);
            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            return fail();
        }

        return msg();
    }

    /**
     * 文件上传=>可能无法使用
     * @param $file
     * @return string
     */
    function upload_img($file)
    {
        $url_path = 'uploads/cover';
        $rule = ['jpg', 'png', 'gif'];
        if ($file->isValid()) {
            $clientName = $file->getClientOriginalName();
            $tmpName = $file->getFileName();
            $realPath = $file->getRealPath();
            $entension = $file->getClientOriginalExtension();
            if (!in_array($entension, $rule)) {
                return '图片格式为jpg,png,gif';
            }
            $newName = md5(date("Y-m-d H:i:s") . $clientName) . "." . $entension;
            $path = $file->move($url_path, $newName);
            $namePath = $url_path . '/' . $newName;
            return $path;
        }
    }


    public function DecimalToWord($num){
       if((int)$num>$num||$num<(int)$num) return $num ;
        $chiUni = array('','十', '百', '千', '万', '亿', '十亿', '百亿', '千亿');
        $num2= $num;
        $dep=0;
        do{
            $num2*=10;
            $dep++;
        }while ($num2<1&&$dep<=8);
        //var_dump($dep);
        return $chiUni[$dep]."分之".$this->numToWord($num2);

    }

    /**
     * 把数字1-1亿换成汉字表述，如：123->一百二十三
     * @param [num] $num [数字]
     * @return [string] [string]
     */
    function numToWord($num)
    {
        if(is_float($num)) return $num;

        $chiNum = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
        $chiUni = array('','十', '百', '千', '万', '亿', '十', '百', '千');

        $chiStr = '';

        $num_str = (string)$num;

        $count = strlen($num_str);
        $last_flag = true; //上一个 是否为0
        $zero_flag = true; //是否第一个
        $temp_num = null; //临时数字

        $chiStr = '';//拼接结果
        if ($count == 2) {//两位数
            $temp_num = $num_str[0];
            $chiStr = $temp_num == 1 ? $chiUni[1] : $chiNum[$temp_num].$chiUni[1];
            $temp_num = $num_str[1];
            $chiStr .= $temp_num == 0 ? '' : $chiNum[$temp_num];
        }else if($count > 2){
            $index = 0;
            for ($i=$count-1; $i >= 0 ; $i--) {
                $temp_num = $num_str[$i];
                if ($temp_num == 0) {
                    if (!$zero_flag && !$last_flag ) {
                        $chiStr = $chiNum[$temp_num]. $chiStr;
                        $last_flag = true;
                    }
                }else{
                    $chiStr = $chiNum[$temp_num].$chiUni[$index%9] .$chiStr;
                    $zero_flag = false;
                    $last_flag = false;
                }
                $index ++;
            }
        }else{
            $chiStr = $chiNum[$num_str[0]];
        }
        return $chiStr;
    }



}
