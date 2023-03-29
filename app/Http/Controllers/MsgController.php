<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Auth;

class MsgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request , [
            'msg'=>'required',
            'chat_id'=>'required'
        ]);
        $cu = Auth::user()->id;

        $msg = new Message;
        $msg->msg = $request->msg;
        $msg->user_id = $cu;
        $msg->chat_id = $request->chat_id;
        $msg->seen = 0;
        $msg->save();
        if(!empty($msg)){
            $resp["status"] = 1;
            $resp["txt"] = "Successfully create New Msg";
            $resp["obj"] = $msg;
        }else{
            $resp["status"] = 0;
            $resp["txt"] = "Successfully create New Msg";
        }

        return json_encode($resp);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function message_list(Request $request){
        $Chat = Chat::find($request->c_id);
        if($request->limit > 10){
            $msgs = $Chat->msgs()->take((int)$request->limit)->skip((int)$request->limit - 10)->orderBy("id" , "desc")->get();
        }else{
            $msgs = $Chat->msgs()->take($request->limit)->orderBy("id" , "desc")->get();
        }
        $me = Auth::user();
        $html = view('layouts.msg_list',compact('msgs','me'))->render();
        $resp['status'] = 1;
        $resp['txt'] = (string) $html;

        return json_encode($resp);
    }

    public function new_message_list(Request $request)
    {
        $Chat = Chat::find($request->c_id);
        $me = Auth::user();
        if($request->me == 1){
            $msgs = $Chat->msgs()->where('seen' , 0)->where('user_id' , $me->id)->orderBy("id" , "desc")->take(1)->get();
        }else{
            $msgs = $Chat->msgs()->where('seen' , 0)->where('user_id' , '<>' , $me->id)->take(1)->get();
        }
        
            $html = view('layouts.msg_list',compact('msgs','me'));
            $resp['status'] = 1;
            $resp['txt'] = $html;
        
        return response()->json($resp);
    }

    
}
