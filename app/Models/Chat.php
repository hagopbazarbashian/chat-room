<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Chat extends Model
{
    public function users(){
        return $this->belongsToMany(User::class);
    } 

}
