<?php

namespace App\Admin\Actions\Dy;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
//php artisan admin:action Dy\\TXOK --grid-row --name="通过"
//php artisan admin:action Dy\\TXfail --grid-row --name="驳回"
use Modules\Douying\Entities\DyUser;
use Modules\Douying\Entities\DyTx;
class TXfail extends RowAction
{
    public $name = '驳回';

    public function handle(Model $model)
    {
        // $model ...
        $amount  = $model["amount"];
        $userid= $model["userid"];
        $user = DyUser::where("id",$userid)->first();
        //1 更新USER
        $res1 = DyUser::where("id",$userid)->update(["yue"=>$user["yue"]+$amount,"dongjie"=>$user["dongjie"]-$amount]);
        if(!$res1) return $this->response()->warning('操作异常1!')->refresh();
        //2 更新TX
        $res2 = DyTx::where("id",$model["id"])->update(["status"=> 2,"done"=>time()]);
        if($res2)  return $this->response()->success('已驳回该提现.')->refresh();
        return $this->response()->warning('操作异常2!')->refresh();

    }

}