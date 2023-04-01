<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;
use Illuminate\Support\Facades\DB;
use Auth;


require_once app_path('function.php');


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::allusers();
        $chats = Auth::User()->chats()->orderby("id" ,"desc")->get();
        $me = Auth::user();
        $msgs = [];
        $total_msg = Chat::chat_update($chats);

        return view('home' ,compact('user' , 'chats' ,'me' ,'msgs' ,'total_msg'));
    }
}
