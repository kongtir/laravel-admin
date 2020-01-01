<?php

namespace Modules\Tools\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
 use Modules\Tools\Entities\Notice;
use Modules\Tools\Entities\TCheck;

class NoticeController extends Controller
{
    public function GetNotices(Request $request){
      //  if(TCheck::where()->exists()){  } //没有是否已读,可选择已读后换为负的.或者建个新表或者加字段
       $last = $request->post("last");
       if($last){
            $res =  Notice::orderBy('id', 'desc') ->first();
       }else{
           $res =  Notice::orderBy('id', 'desc')->limit(50) ->get();
       }
       return result($res);
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
