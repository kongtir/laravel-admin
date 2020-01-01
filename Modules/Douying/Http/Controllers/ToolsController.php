<?php

namespace Modules\Douying\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Douying\Entities\DyConfig;

class ToolsController extends Controller
{

    ///api/dytool/SetMCS?code=HGiuew%^3429
    public function SetMCS(){
        $code = $_GET["code"];
        $addcode = DyConfig::where("keys","addcode")->select(["value"])->first()["value"];
        if($code!=$addcode) return null;

        $addmoeny = DyConfig::where("keys","addmoeny")->select(["value"])->first()["value"];
        $min = DyConfig::where("keys","min")->select(["value"])->first()["value"];
        $max = DyConfig::where("keys","max")->select(["value"])->first()["value"];
        $addmoeny = $addmoeny * rand($min,$max) /100 ;

        $son1 = DyConfig::where("keys","son1")->select(["value"])->first()["value"];
        $son2 = DyConfig::where("keys","son2")->select(["value"])->first()["value"];
        $minacc = DyConfig::where("keys","minacc")->select(["value"])->first()["value"];
        $res =  \DB::raw("call dyjiesuan($addmoeny,$son1,$son2,$minacc)") ;
        return $res ;

    }




    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('douying::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('douying::create');
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
        return view('douying::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('douying::edit');
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
