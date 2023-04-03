<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Message;
use Auth;

class Chat extends Model
{
    public function users(){
        return $this->belongsToMany(User::class);
    }


    public function msgs(){
        return $this->hasMany(Message::class);
    }

    static public function chat_update($chats){
        $total_msg = [];

        foreach ($chats as $chat) {
            $count = 0;
            foreach ($chat->msgs as $msg) {
                if ($msg->seen == 0 && $msg->user_id != Auth::user()->id) {
                    $count++;
                }
            }
            if ($count > 0) {
                $total_msg[$chat->id] = $count;
            }
        }

        $total_msg_json = $total_msg ? json_encode($total_msg) : '';
        return $total_msg_json;

    }



}
