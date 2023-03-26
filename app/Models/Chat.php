<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Message;

class Chat extends Model
{  
    public function users(){
        return $this->belongsToMany(User::class);
    }   


    public function msgs(){
        return $this->hasMany(Message::class);
    }   

}
