<style>

.new-msg {
  color:black;
  font-weight:bold;
  animation: myanimation 2s infinite;
}

@keyframes myanimation {
  0% {background-color: #c2c2c2;}
  25%{background-color:#fff;}
  50%{background-color:#c2c2c2;}
  75%{background-color:#fff;}
  100% {background-color: #c2c2c2;}
}
</style>
@if(count($chats) > 0)
@foreach ($chats as $chat)
<div id="{{ $chat->id }}"  class="chat-item">
    @if(count($chat->users) > 2)
    <img class="img-circle img-responsive chat-item-img"  src="{{asset('/img/default-group.png')}}">
    @else
    <img class="img-circle img-responsive chat-item-img"  src="{{asset('/img/default-user.jpg')}}">
    @endif
    <div class="chat-item-users">
        <?php
        $un = [];
        foreach ($chat->users as $u) {
            if($me->id !== $u->id){
                $un[]= $u->name;

            }
        }
        $un =  implode("," , $un);
        echo (strlen($un) > 17) ? substr($un , 0 , 17) . "...":$un;

        ?>
    </div>
    <?php
        if(array_key_exists($chat->id , $total_msg) ){
        $c = ($total_msg[$chat->id] > 20) ? "20+" : $total_msg[$chat->id];
        echo "<div class='new-msg-count'>".$c."</div>";
        }

    ?>

    <div class="flex">
        <i class="fa fa-trash chat-item-delete" value="{{ $chat->id }}" aria-hidden="true"></i>
    </div>
</div>
@endforeach

@else
<div class="no-record text-center">No chat Exist</div>
@endif

