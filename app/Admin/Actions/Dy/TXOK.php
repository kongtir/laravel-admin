<?php

namespace App\Admin\Actions\Dy;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Modules\Douying\Entities\DyUser;
use Modules\Douying\Entities\DyTx;
class TXOK extends RowAction
{
    public $name = '通过';

    public function handle(Model $model)
    {
        // $model ...
        $amount  = $model["amount"];
        $userid= $model["userid"];
        $user = DyUser::where("id",$userid)->first();
        //1 更新USER
        $res1 = DyUser::where("id",$userid)->update(["dongjie"=>$user["dongjie"]-$amount]);
        if(!$res1) return $this->response()->warning('操作异常3!')->refresh();
        //2 更新TX
        $res2 = DyTx::where("id",$model["id"])->update(["status"=> 1,"done"=>time(),"payed"=>1]);
        if($res2)  return $this->response()->success('已通过提现.')->refresh();
        return $this->response()->warning('操作异常4!')->refresh();
    }

}