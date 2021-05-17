@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">发私信给
                        @if($messages->first()->from_user->id == Auth::id())
                        {{$messages->first()->to_user->name}}
                        @else
                        {{$messages->first()->from_user->name}}
                        @endif
                        :</div>
                    <div class="panel-body">
                    <form action="/inbox/{{$dialog_id}}/store" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="body" class="form-control"></textarea>
                        </div>
                        <div class="form-group pull-right">
                            <button class="btn btn-success">发送私信</button>
                        </div>
                    </form>
                    <div class="messages-list">
                        @foreach($messages as $message)
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <img src="{{ $message->from_user->avatar }}" alt="" width="36">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        @if($message->from_user->id == Auth::id())
                                            我
                                            @else
                                            <a href="#">
                                                {{ $message->from_user->name }}
                                            </a>
                                        @endif
                                    </h4>
                                    <p>
                                        {{ $message->body }} <span class="pull-right">{{ $message->created_at }}</span>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
