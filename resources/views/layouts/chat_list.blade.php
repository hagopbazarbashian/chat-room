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
    <div class="new-msg-count">6</div>
    <div class="flex">
        <i class="fa fa-trash chat-item-delete" value="{{ $chat->id }}" aria-hidden="true"></i>
    </div>
</div>
@endforeach

@else
<div class="no-record text-center">No chat Exist</div>
@endif

