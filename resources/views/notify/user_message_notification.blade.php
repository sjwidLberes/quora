<li class="notifications">
    <a href="{{route('message.dialog',$notification->data['dialog_id'])}}" >{{$notification->data['name']}}给你发送了一条私信</a> <span class="pull-right">{{$notification->created_at->diffForHumans()}}</span>
</li>