<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Chat;

class Message extends Model
{

    public function chat(){
        return $this->belongsTo(Chat::class);
    }   

}
  