@extends('profile.main')
@section('profile-content')
    <div class="profileMain-content">
        @foreach($user->followings as $following)
            <div class="list-item">
                <div class="col-md-10">
                    <img class="avatar" src="{{$following->avatar}}" alt="">
                    <a class="name" href="{{route('profile.question',$following->id)}}">{{$following->name}}</a>
                </div>
                <div class="col-md-1">
                    <user-follow-button user_id="{{$following->id}}"></user-follow-button>
                </div>
                <div class="col-md-1">
                    <div class="meta-info">{{$following->follower_count}}人关注</div>
                </div>
            </div>
        @endforeach
    </div>
@endsection