<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatRoomController;
use App\Http\Controllers\MsgController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which    `
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    route::post('/store' ,[ChatRoomController::class , 'store']);
    Route::post('/deletechatlist' ,[ChatRoomController::class , 'destroy']);
    Route::post('/message-list' ,[MsgController::class , 'message_list']);
    Route::post('/new-message-list' ,[MsgController::class , 'new_message_list']);
    Route::post('/message' ,[MsgController::class , 'store']);
});



