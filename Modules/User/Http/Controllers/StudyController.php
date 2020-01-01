<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Models\Config;
use Modules\User\Entities\StudyShop;
use App\Untils\CommFunction;
use App\User;
use Illuminate\Support\Facades\Storage;

//php artisan module:make-controller StudyController User
class StudyController extends Controller
{
    //获取礼包列表,可无需任何权限访问
    public function GetStudyGift(Request $request)
    {
        $data = Config::where("keys", "studygift")->first("value");
        if ($data) return success($data["value"]);
        return fail();
    }

    public function StudyShop(Request $request)
    {
        $id = $request->post("id");//操作人id
        $action = $request->post("action");//操作内容
        if (!$action) return fail("Feild Must");
        switch ($action) {
            case "seek"://求购
                $dot = $request->post("dot");//售卖点:在第一步的时候使用和验证
                $dotList = Config::where("keys", "studygift")->first("value");
                $dotList = explode("，", $dotList["value"]);
                if (!in_array($dot, $dotList)) return fail("数据不在字典中!");
                //在数据表中插入数据就代表完成
                $dat = StudyShop::insert(["buyid" => $id, "seektime" => time(), "dot" => $dot, "rmb" => $dot]);
                if ($dat) return msg();
                return fail();
                break;
            case "findtime": //买家 点击出售
                $studyid = $request->post("studyid");//需要检查是不是这个人的并且核对数据状态
                $data = StudyShop::where("id", $studyid)->where("sellerid", 0)->first();
                if (!$data) return fail("交易不存在!");
                $dat2 = StudyShop::where("id", $studyid)->update(["findtime" => time(), "sellerid" => $id]);
                if (!$dat2) fail();
                //扣除学习点
                $dat3 = CommFunction::ChangeAcc($id, -1 * $dat2["dot"], "study", "出售", "$id-{$dat2["buyid"]}");
                if ($dat3) return msg();
                return fail();


                break;
            case "canceltime": //任意一方点击取消
                $studyid = $request->post("studyid");//需要检查是不是这个人的并且核对数据状态->where("sellerid",">",0)
                $data = StudyShop::where("id", $studyid)->where("canceltime", 0)
                    ->where("finishtime", 0)->first();
                if (!$data) return fail("该订单不可取消");
                //取消订单,如果有人计划售出则把钱还回去
                $phone = User::where("id", $id)->first("phone")["phone"];
                $dat3 = StudyShop::where("id", $studyid)->update(["canceltime" => time(), "cancelremark" => "$phone 取消交易"]);
                if (!$dat3) return fail();
                if ($data["sellerid"]) $dat4 = CommFunction::ChangeAcc($id, $data["dot"], "study", "出售", "{$data["sellerid"]}-{$data["buyid"]}");
                if (!$dat4) return fail();
                return msg();
                break;
            case "finishtime": //完成交易
                $studyid = $request->post("studyid");
                $data = StudyShop::where("id", $studyid)->where("buyid", ">", 0)->where("sellerid", ">", 0)
                    ->where("finishtime", 0)->where("canceltime", 0)->first();
                if (!$data) return fail("无法完成交易");
                //给求购用户加点
                if ($data["sellerid"] != $id) return fail("您无权操作!");
                //先改变状态
                $dat3 = StudyShop::where("id", $studyid)->update(["finishtime" => time()]);
                if (!$dat3) return fail("交易失败E71");
                $dat5 = CommFunction::ChangeAcc($data["buyid"], $data["dot"], "study", "交易完成", "{$data["sellerid"]}-{$data["buyid"]}");
                if (!$dat5) return fail();
                return msg();
                break;
            case "img":
                $studyid = $request->post("studyid");
                $data = StudyShop::where("id", $studyid)->where("img", "")->where("sellerid", ">", 0)
                    ->where("finishtime", 0)->where("canceltime", 0)->first();
                if (!$data) return fail("图片上传失败!");

                //图片文件上传
                $img = $request->file('img')->store('/public/uploads/studyshop/' . date('Y-m-d'));
                //上传的头像字段avatar是文件类型
                $img = Storage::url($img);//就是很简单的一个步骤
                //E12345  保存图片
                $dat6 = StudyShop::where("id", $studyid)->update(["img" => $img]);
                if (!$dat6) return fail();
                return success($img);

                break;
            default :
                return fail("操作不允许E78");
                break;
        }


    }

    //获取求购列表:必须登陆才能获取
    public function GetStudySellerList(Request $request)
    {
        $action = $request->post("action");
        $id = $request->post("id");
//        orWhere(function ($q) use ($id){
//            $q->where("",$id)->where("",$id);
//        })->
        switch ($action) {
            case "seek":
                //自己的求购列表:已挂上但没有完成的
              $data =  StudyShop::where("   ",$id)
                  ->where("sellerid",0)
                  ->where("findtime",0)->where("canceltime",0)->where("finishtime",0)
                  ->get();
                    return result($data);
                break;
            case "all":
                //全部销售列表:本列可以不登陆获取
                $data =  StudyShop::where("sellerid",0)
                    ->where("findtime",0)->where("canceltime",0)->where("finishtime",0)
                    ->get();
                return result($data);
                break;
            case "my":
                $status = $request->post("status");
                switch ($status) {
                    case "seller":  //正在进行[已售未打款]
                        $data =  StudyShop::where("sellerid",">",0)
                            ->where("buyid",$id)
                            ->where("findtime",">",0)->where("canceltime",0)->where("finishtime",0)
                            ->get();
                        return result($data);

                        break;
                    case "finish"://已完成
                        $data =  StudyShop::where("sellerid",">",0)
                            ->where("buyid",$id)
                            ->where("findtime",">",0)->where("canceltime",0)->where("finishtime",">",0)
                            ->get();
                        return result($data);
                        break;
                    case "cancel"://已取消
                        $data =  StudyShop::where("sellerid",">",0)
                            ->where("buyid",$id)
                            ->where("findtime",">",0)->where("canceltime",">",0)->where("finishtime",0)
                            ->get();
                        return result($data);
                        break;
                    default:
                        return fail();
                        break;
                }
                break;
            default:
                return fail();
                break;
        }
    }


    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('user::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('user::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
