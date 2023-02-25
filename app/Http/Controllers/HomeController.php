<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // join
        // $test = DB::table('users')->join('orders' ,'users.id' , '=' ,'orders.user_id')->select('users.name' , 'orders.order_number')->get();
        // $test = DB::table('users')->leftjoin('orders' ,'users.id' , '=' ,'orders.user_id')->select('users.name' , 'orders.order_number')->get();
        // $test =  DB::table('users')->crossJoin('orders')->select('users.name' , 'orders.order_number')->get();
        // return $test;
        return view('home');
    }
}