@if(count($msgs) > 0)
    @foreach ($msgs as $msg)
    <div id ={{ $msg->id }} class="msg-item <?php echo($msg->user_id == $me->id) ? 'me' : '' ; ?>">
        <img class="img-circle img-responsive msg-item-img"  src="{{asset('/img/default-user.jpg')}}">
        <div class="msg-item-txt">
            {{ $msg->msg }}
            <div class="msg-item-data">
                @if ($msg->created_at->diffInHours(\Carbon\Carbon::now(), true) > 24 )
                {{ $msg->created_at->format('d F Y h:i A') }}
                @else
                {{ $msg->created_at->diffForHumans() }}
                @endif
            </div>
        </div>
    </div>
    @endforeach
@else
    <div class="no-record text-center">No chat exists</div>
@endif


{{-- <div class="msg-item me">
    <img class="img-circle img-responsive msg-item-img"  src="{{asset('/img/default-user.jpg')}}">
    <div class="msg-item-txt">
        hello hello
        <div class="msg-item-data">
            12-2-2023
        </div>
    </div>
 </div> --}}



