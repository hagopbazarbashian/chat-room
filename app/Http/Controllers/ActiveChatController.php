<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use App\Models\ActiveChat;
use Auth;


class ActiveChatController extends Controller
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
            'c_id'=>'required'
         ]);
         $cu = Auth::user()->id;
         $chk = ActiveChat::where('user_id' , $cu)->first();
         if(!empty($chk)){
            $chk->chat_id = $request->c_id;
            $chk->save();
         }else{
            $active = new ActiveChat;
            $active->chat_id = $request->c_id;
            $active->user_id = $cu;
            $active->typing = false;
            $active->save();
         }

         if(!empty($active) || !empty($chk)){
            $resp['status']= 1;
            $resp['txt']= "Successfully";

         }else{
            $resp['status']= 0;
            $resp['txt']= "Something is wrong";
         }

         return response()->json($resp);
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

    public function set_active(Request $request){
        $cu = Auth::user()->id;
        $chk = ActiveChat::where('user_id' , $cu)->first();

        if(!empty($chk)){
            $chk->typing = $request->con;
            $chk->save();
        }

        if(!empty($chk)){
            $resp['status'] = 1;
            $resp['con'] = $request->con;
        }else{
            $resp['status'] = 0;
        }

        return response()->json($resp);

    }


}
