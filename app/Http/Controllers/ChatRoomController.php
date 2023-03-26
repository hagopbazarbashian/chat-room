<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use Auth;

class ChatRoomController extends Controller
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
         $this->validate($request ,[
            'users'=>"required"
         ]);

         $chk_chats = Auth::user()->chats;

         $already_exist ="";
         foreach($chk_chats as $ct){
            $un = [];
            $already_exist =false;
            foreach($ct->users as $u){
                if(Auth::user()->id != $u->id){
                    $un[]= (string)$u->id;

                }

            }

            if(empty(array_diff($request->users, $un))){
                $already_exist = true;
                break;
            }else{
                $already_exist = false;
            }

        }

        if(!$already_exist){
            $chat = new Chat;
            $chat->user_id = Auth::user()->id;
            $chat->save();
            $chat->users()->attach(Auth::user()->id);
            foreach($request->users as $id){
                $chat->users()->attach($id);
            }
            if(!empty($chat)){
                $resp['status'] = 1;
                $resp['txt'] = "Create in your chat list";
                $resp['obj'] = $chat;
                $resp['objusers'] = $chat->users;

            }else{
                $resp['status'] = 0;
                $resp['txt'] = "Somthing went wrong";
            }
        }else{
            $resp['status'] = 0;
            $resp['txt'] = "Chat Aleady Exist !";
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
    public function destroy(Request $request)
    {
         dd($request->chatitem);
    }
    
}
   