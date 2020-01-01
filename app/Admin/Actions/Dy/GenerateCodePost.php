<?php

namespace App\Admin\Actions\Dy;

use Encore\Admin\Actions\Action;
use Illuminate\Http\Request;
use Modules\Douying\Entities\DyCode;
class GenerateCodePost extends Action
{
    protected $selector = '.generate-code-post';


    public function handle(Request $request)
    {


        $num=0 ;
        $_arr =[];
        for ($x=0; $x<10000; $x++) {
            $num++;
            array_push($_arr,["phone"=>$this->generatePhone(),
                "psd"=>$this->generateKey(9) ,"keys"=> $this->generateKey(6)]);
           if(count($_arr)>150){
               DyCode::insert($_arr);
               $_arr =[];
           }
        }
        if(count($_arr)>0)DyCode::insert($_arr);
        return $this->response()->success("数据生成成功($num)!")->refresh();
    }

    public function html()
    {
        return <<<HTML
        <a class="btn btn-sm btn-default generate-code-post">生成数据</a>
HTML;
    }

    public function generateKey($length){
        $BCode = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $JinZhi =strlen($BCode)-1;
        $len = 0;
        $res = "";
        while ($len<$length){
            $res.=$BCode[rand(0, $JinZhi)] ;
            $len++;
        }
        return $res ;
    }
    public function generatePhone(){
        $BCode="0123456789";
        //134(0-8)、135、136、137、138、139 ,150、151、152 188  , 130、131、132、155 , 133、153 、189
        $stuff = array(130,131,132,133,134,135,136,137,138,139,150,151,152,188,130,131,132,155,133,153 ,189);
        $len = count($stuff)-1;
        $stuff_0 = $stuff[rand(0, $len)] ;
        $stuff_1 = rand(10351206, 91609254);
        return $stuff_0.$stuff_1;
    }
}