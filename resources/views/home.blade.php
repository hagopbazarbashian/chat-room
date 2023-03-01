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
            </div>
        </div>
    </div>
</div>
@endsection
