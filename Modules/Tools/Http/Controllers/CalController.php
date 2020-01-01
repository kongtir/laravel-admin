<?php

namespace Modules\Tools\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
//php artisan module:make-controller CalController Tools
use Modules\Tools\Entities\TCalculator;
use App\Untils\CommFunction;
use PhpParser\Node\Expr\Cast\Object_;

class CalController extends Controller
{
    public function GetCalList(){
        return result(TCalculator::get());
    }

    public function bobi(Request $request)
    {
        $totalmoney = $request->post("totalmoney");
        $per = $request->post("per");
        $min = $request->post("min");
        if (!$totalmoney || $totalmoney <= 0) $totalmoney = 1;
        if (!$per || $per <= 0 || $per >= 1) $per = 0.0005;
        if (!$min || $min < 0.005) $min = 0.01;
        $collect = [];//汇总信息
        $collect["totalmoney"] = $totalmoney;//总金额
        $collect["per"] = $per;//拨比
        $cmf = new CommFunction();
        $collect["pername"] = $cmf->DecimalToWord($per);
        $collect["min"] = $min;//

         $list[0] = [];//数据列表

        $DayShared = 0;//日分享

        $day=0;//当前天数
        $dayall = 0;//总天数
       // $month=0;//当前月份
        $year = 0; //当前年份
        $SharedAll = 0 ;//当前总分享

        $Surplus = $collect["totalmoney"];//当前剩余
        //$list[0]=[];
       do{

            $day++;//天数
            if($day %366==0){
               $year++;
               $day=1;
            }
            $dayall++;//总天数
            $DayShared=$collect["per"]*$Surplus;//日分享

            $Surplus -= $DayShared;//当前剩余
            $SharedAll+=$DayShared;//当前总分享
            if(count($list)<=$year){
                $list[$year]=[];
            }
           array_push($list[$year],["Surplus"=>round($Surplus,2),
               "SharedAll"=>round($SharedAll,2),"day"=>$day,"year"=>$year,"dayall"=>$dayall,
               "DayShared"=>round($DayShared,2)]);
          // var_dump($DayShared,$Surplus,$collect["per"],$DayShared<$min);exit();
        } while ($DayShared>$min+0.005);
        $collect["dayall"] =$dayall;
        $collect["year"] =$year;
        $collect["day"] =$day;
        $res["collect"] = $collect;
        $res["list"] = $list;
        return result($res);
    }

    public  function  duipeng(Request $request){
        $dan  =$request->post("dan");//每单金额
        $f1   =$request->post("f1"); //直推奖励
        $f2   =$request->post("f2");//2代奖励
        $f3   =$request->post("f3");//3代奖励
        $dp   =$request->post("dp");//对碰奖励
        $max  =$request->post("max");//封顶金额
        $sxf  =$request->post("sxf");//手续费
        $ceng =$request->post("ceng");//层数
        $f[0]=$f1;$f[1]=$f2;$f[2]=$f3;
        if($ceng>25)$ceng=25;
        $num =pow(2,$ceng) -1;//根据层数算有多少人,满层多少人

        //$num = $this-> GetCengForNum($ceng);//多少层一共多少人,id等信息
        $res=[];
        $res[0]=$this-> NumToDPUser(0);//无意义数据
        $allmoeny = 0;//总获得金额
        $outmoney = 0;//总拨出金额
        $aid =1; //账目ID
        $log=[];
        //$L_left=0;
       // $L_right=0;
        for ($i = 1; $i <= $num; $i++) {
            $res[$i] = $this->NumToDPUser($i);
            //每进来一个就开始投资
            $res[$i]["touzhi"] += $dan; //此处应作记录
            $res[$i]["huode"] -= $dan;
            $allmoeny += $dan;
            array_push($res[$i]["zhangdan"], [
                "aid" => $aid++, 'change' => -1 * $dan, "uid" => $i, "curmoney" => $res[$i]["huode"], "remark" => "投资$dan"
            ]);
            $do = 0;
            $fid = $res[$i]["fid"];//上级ID

            if ($i % 2 == 0) {
                $left =$dan; $right =  0;
            } else {
                $left =0; $right =  $dan;
            }
            do {
              //  array_push($log, $fid);
                 $res[$fid]["left"] += $left; $res[$fid]["right"] += $right;
                if ($do < 3) {
                    //层级奖励只发三代
                    $res[$fid]["huode"] += $f[$do] * $dan; //此处应作记录
                    $outmoney += $f[$do] * $dan;
                    array_push($res[$fid]["zhangdan"], [
                        "aid" => $aid++, 'change' => $f[$do] * $dan, "uid" => $fid, "curmoney" => $res[$fid]["huode"]
                        , "remark" => ($do + 1) . "代奖励" //[{$f[$do]}]
                    ]);
                }
                if ($res[$fid]["left"] > 0 && $res[$fid]["right"] > 0) {
                    $dp_shengyu = abs($res[$fid]["left"] - $res[$fid]["right"]); //剩余未对碰金额
                    $dpmax = $res[$fid]["left"] > $res[$fid]["right"] ? $res[$fid]["left"] - $dp_shengyu : $res[$fid]["right"] - $dp_shengyu;
                    $dpmoney = $dpmax * $dp;
                    if ($dpmoney > $max) $dpmoney = $max;
                    $res[$fid]["huode"] += $dpmoney; //此处应作记录
                    array_push($res[$fid]["zhangdan"], [
                        "aid" => $aid++, 'change' => $dpmoney, "uid" => $fid, "curmoney" => $res[$fid]["huode"]
                        , "remark" => "$dpmax 对碰"
                    ]);
                    $outmoney += $dpmoney;
                    $res[$fid]["left"] -= $dpmax;
                    $res[$fid]["right"] -= $dpmax;
                }
                if ($fid % 2 == 0) {
                    $left =$dan; $right =  0;
                } else {
                    $left =0; $right =  $dan;
                }
                $fid = $res[$fid]["fid"]; $do++;
            } while ($do < 120 && $fid > 0);
        }

        $cmf = new CommFunction();

        $out["list"] = $res ;
        //$out["log"] = $log;
       // $out["L_left"] = $L_left;
      //  $out["L_right"] = $L_right;
        $out["data"] = [
            "dan"=>$dan,
            "f1"=>$cmf->DecimalToWord($f1),
            "f2"=>$cmf->DecimalToWord($f2),
            "f3"=>$cmf->DecimalToWord($f3),
            "dp"=> $cmf->DecimalToWord($dp),
            'sxf' => $cmf->DecimalToWord($sxf),
            "max"=>$max,
            'ceng'=>$ceng,
            "outmoney"=>$outmoney,
            "outmoney_sxf"=>$outmoney*(1-$sxf),
            "allmoeny"=>$allmoeny,"bobi"=> round(($outmoney*(1-$sxf))/$allmoeny*100,3)
        ] ;
        return result($out) ;
    }

    //根据编号算位置
    public function NumToDPUser($num=1){
        //1 第多少层
        //2 上级编号是多少
        $ceng = (int)pow($num+1, 1/2) +1;
        $c=0;
        do{
            $c++;
            if(pow(2,$ceng-1)<=$num&&$num<pow(2,$ceng)) break;
            $ceng--;
        }while($c<10&&$ceng>0);
        $res["id"]= $num;
        $res["ceng"]=$ceng; //第几层

        $res["fid"]=($num - $num % 2)/2 ; //上级ID
        $res["touzhi"]=0;
        $res["huode"]=0;
        $res["left"]=0;//对碰左边
        $res["right"]=0;//对碰右边
        $res["zhangdan"]=[];//账单列表
        return $res;
    }





    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('tools::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('tools::create');
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
        return view('tools::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('tools::edit');
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
