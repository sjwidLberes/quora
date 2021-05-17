<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
        Laravel.apiToken = "{{Auth::check() ? 'Bearer '.Auth::user()->api_token : 'Bearer '}}";
        @if(Auth::check())
            window.AuthUser = {
            name:"{{Auth::user()->name}}",
            avatar:"{{Auth::user()->avatar}}"
        }
        @endif
    </script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-inverse navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;<li><a class="nav-link-title" href="/">首页</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <li class="ask-question"><a class="ui button blue" href="{{route('question.create')}}"><i class="fa fa-paint-brush fa-icon-lg"></i>写问题</a></li>
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a class="nav-li-login" href="{{ route('login') }}">登录</a></li>
                            <li><a class="nav-li-login" href="{{ route('register') }}">注册</a></li>
                        @else
                            <li>
                                <a href="{{route('notify.index')}}" class="user-notify-bell">
                                    <i class="fa fa-bell">

                                    </i>
                                    @if(Auth::user()->unreadNotifications->count()!==0)
                                        <span class="badge bell-badge">{{Auth::user()->unreadNotifications->count()}}</span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a href="{{route('profile.question',Auth::user()->id)}}">
                                    {{ Auth::user()->name }}
                                </a>
                            </li>
                            <li>
                                <a class="nav-header-avatar dropdown-toggle nav-user-avatar" data-toggle="dropdown" role="button"
                                   aria-expanded="false" style="padding: 6px 15px 6px 0px;">
                                    <img src="{{Auth::user()->avatar}}">
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{route('profile.question',Auth::user()->id)}}"><i class="fa fa-user fa-icon-lg"></i> 我的主页</a>
                                    </li>
                                    <li>
                                        <a href="{{route('auth.set')}}"> <i class="fa fa-cogs fa-icon-lg"></i>个人设置</a>
                                    </li>
                                    <li>
                                        <a href="/dashboard"> <i class="fa fa-coffee fa-icon-lg"></i>后台管理</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="fa fa-sign-out fa-icon-lg"></i>退出登录
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>

                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            @if (session()->has('flash_notification.message'))
                <div class="alert alert-{{ session('flash_notification.level') }}">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                    {!! session('flash_notification.message') !!}
                </div>
            @endif
        </div>
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        window.Echo.channel('aaa')
            .listen('UserFollowEvent', (e) => {
//                console.log(e);
            });
        window.Echo.private('chat-room.9')
            .listen('ChatMessageWasReceived', (e) => {
                console.log(e.user, e.chatMessage);
            });
        {{--window.Echo.private('App.User.'+"{{Auth::user()->id}}")--}}
            {{--.notification((notification) => {--}}
                {{--console.log(notification);--}}
                {{--$("title").html("您收到一条新的消息");--}}
            {{--});--}}
    </script>
    <script>
        $('#flash-overlay-modal').modal();
    </script>
    @yield('myjs')
</body>
</html>
