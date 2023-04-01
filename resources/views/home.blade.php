@extends('layouts.app')
@section('content')
@section('style')
    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet">
@endsection
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
           <div class="panel panel-default">
            <div  class="panel-heading">Chat List</div>
            <div id="chat-body" class="panel-body">
                 @include('layouts.chat_list')
            </div>
           </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">conversion</div>
                <div id="msg-body" class="panel-body">
                     {{-- <div class="no-chat">No chat selected</div> --}}
                    @include('layouts.msg_list')
                </div>
                <div class="msger-inputarea" id="create-msg-form">
                    <input type="text" class="msger-input" id="msg" disabled style="width: 100%;" placeholder="Enter your message...">
                    <div id="typing_on"></div>
                    <input type="hidden"  id="chat-id" name="chat_id" value="">
                    <button  class="msger-send-btn" id="msg-send" disabled><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
