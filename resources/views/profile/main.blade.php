@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="profile-header">
                    <div class="profile-card">
                        <div class="userCover-panel">
                            <div class="userCover">
                                <img class="userCover-img" src="{{url('/images/pattern.jpeg')}}" alt="">
                                <div class="userCover-link"></div>
                            </div>
                        </div>
                        <div class="header-wrapper">
                            <div class="header-wrapper-main">
                                <div class="user-profile-avatar">
                                    <div class="userAvatar">
                                        <img src="{{$user->avatar}}" alt="">
                                    </div>
                                </div>
                                <div class="profile-header-content">
                                    <div class="profile-header-conHeader">
                                        <h1 class="profile-user-name"><span>{{$user->name}}</span></h1>
                                    </div>
                                    <div class="profile-header-conBody">
                                        <div class="ProfileHeader-info">
                                            <div class="ProfileHeader-infoItem">
                                                <i class="fa fa-location-arrow"></i>{{$user->setting['place']}}
                                            </div>
                                            <div class="ProfileHeader-infoItem">
                                                <i class="fa fa-github"></i>{{$user->setting['github']}}
                                            </div>
                                            <div class="ProfileHeader-infoItem">
                                                <i class="fa fa-link"></i><a href=""
                                                                             target="_blank"></a>{{$user->setting['site']}}
                                            </div>
                                            <div class="ProfileHeader-infoItem">
                                                <i class="fa fa-cloud"></i>{{$user->setting['introduction']}}
                                            </div>
                                        </div>
                                    </div>
                                    @if(Auth::id()===$user->id)
                                        <a href="/setting" class="ui button inverted blue edit-profile-user">编辑个人资料</a>
                                    @else
                                        <div class="edit-profile-user">
                                            <user-follow-button user_id="{{$user->id}}"></user-follow-button>
                                            <send-message user_id="{{$user->id}}" user_name="{{$user->name}}"></send-message>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="profile-main">
                    <div class="profileMain">
                        <div class="profileMain-header">
                            <ul class="profileMain-tabs">
                                <li class="item"><a href="{{route('profile.question',$user->id)}}">提问</a>{{$user->ask_count}}</li>
                                <li class="item"><a href="{{route('profile.answer',$user->id)}}">回答</a>{{$user->answer_count}}</li>
                                <li class="item"><a href="{{route('profile.like',$user->id)}}">收藏</a>{{$user->collection_count}}</li>
                                <li class="item"><a href="{{route('profile.following',$user->id)}}">关注的人</a>{{$user->following_count}}</li>
                                <li class="item"><a href="{{route('profile.followquestion',$user->id)}}">关注的问题</a>{{$user->followquestion_count}}</li>
                                <li class="item"><a href="{{route('profile.follower',$user->id)}}">粉丝</a>{{$user->follower_count}}</li>
                            </ul>
                        </div>
                        @yield('profile-content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('myjs')
    <script>
        $(document).ready(function () {
            var path_array = window.location.pathname.split('/');
            var scheme_less_url = window.location.protocol + '//' + window.location.host + '/' + path_array[1] + '/' + path_array[2] + '/' + path_array[3];
            console.log(scheme_less_url);
            $('ul.profileMain-tabs>li').find('a[href="' + scheme_less_url + '"]').closest('a').addClass('active');  //链接高亮
        });
    </script>
@endsection
