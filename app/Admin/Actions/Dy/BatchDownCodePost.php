<?php

namespace App\Admin\Actions\Dy;

use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;
use Modules\Douying\Entities\DyCode;
class BatchDownCodePost extends BatchAction
{
    public $name = '立即下载';

    public function handle(Collection $collection)
    {
        $DownData=  "";
        foreach ($collection as $model) {
            if($model["yishou"]==0){
                $DownData.=$model["phone"]."\t".$model["psd"]."\t".$model["keys"]."\r\n";
                DyCode::where("id",$model["id"])->update(["yishou"=>1,"status"=>1,"selltime"=>time()]);
            }
        }
        //dd($DownData);
        $f_name =$this->generateFileName(16).'.txt';
        $fielname ="/dy/CodeFiles/".$f_name;
        $numbytes = file_put_contents(base_path()."/public".$fielname, $DownData);  //创建文件
        //dd($fielname);
        return $this->response()->success('正在下载,请手动刷新')->download($fielname);
        ////->refresh();
    }

    public function generateFileName($length){
        $BCode = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";  //$BCode =  explode('', $BCode);
        $JinZhi =strlen($BCode)-1;  $len = 0;$res = "";
        while ($len<$length){
            $res.=$BCode[rand(0, $JinZhi)] ;
            $len++;
        }
        return $res ;
    }

}