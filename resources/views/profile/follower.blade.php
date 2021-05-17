@extends('profile.main')
@section('profile-content')
    <div class="profileMain-content">
        @foreach($user->followers as $follower)
            <div class="list-item">
                <div class="col-md-10">
                    <img class="avatar" src="{{$follower->avatar}}" alt="">
                    <a class="name" href="{{route('profile.question',$follower->id)}}">{{$follower->name}}</a>
                </div>
                <div class="col-md-1">
                    <user-follow-button user_id="{{$follower->id}}"></user-follow-button>
                </div>
                <div class="col-md-1">
                    <div class="meta-info">{{$follower->follower_count}}人关注</div>
                </div>
            </div>
        @endforeach
    </div>
@endsection