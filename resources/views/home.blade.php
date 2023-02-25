@extends('layouts.app')

@section('content')
<style>
    .panel.panel-default {
    font-size: 16px;
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
           <div class="panel panel-default">
            <div class="panel-heading">Chat List</div>
            <div class="panel-body">
                 <div class="chat-item">
                    <img src="{{asset('/img/default-user.jpg')}}">
                 </div>
            </div>
           </div>
        </div>




        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">conversion</div>
                <div class="panel-body">
                     <div>No chat</div>
                </div>
            </div>
    
        </div>
    </div>
</div>
@endsection
