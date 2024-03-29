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
            $i = 0;
            foreach ($chat->msgs as $msg) {
                if ($msg->seen == 0 && $msg->user_id != Auth::user()->id) {
                    $i++;
                }

            }
            if ($i > 0) {
                $total_msg[$chat->id] = $i;
            }
        }

        return $total_msg;
    }





}
