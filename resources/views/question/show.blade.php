@extends('layouts.app')

@section('content')
<div class="question-panel">
    <div class="question-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-1">
                    <div class="question-panel-main">
                        <div class="question-panel-topics">
                                @foreach($question->topics as $topic)
                                    <a href="" class="topic">{{$topic->title}}</a>
                                @endforeach
                        </div>
                        <h1 class="question-panel-title">
                            {{$question->title}}
                        </h1>

                        <div class="question-panel-detail">
                            {!! $question -> body !!}
                        </div>
                        <div class="question-panel-footer">
                            <div class="question-panel-inner">
                                <comment commentable_type = 'question' commentable_id="{{$question->id}}" count="{{$question->comments->count()}}"></comment>
                                <a class="answer-item-action" href="">
                                    <i class="fa fa-paper-plane fa-icon-sm"></i>分享
                                </a>
                                <a class="answer-item-action question-like" href="">
                                    <i class="fa fa-star fa-icon-sm"></i>收藏
                                </a>

                                <div class="answer-item-action">
                                    <i class="fa fa-ellipsis-h"></i>
                                </div>

                                @if(Auth::check() && Auth::user()->owns($question))
                                    <div class="ui action-buttons">
                                        <a href="{{route('question.edit',$question->id)}}"
                                           class="ui basic button green action-btn">编辑</a>
                                        <form action="{{route('question.destroy',$question->id)}}" method="post"
                                              class="delete-form action-btn">
                                            {{method_field('DELETE')}}
                                            {!! csrf_field() !!}
                                            <button class="ui basic button red">删除</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-12 col-xs-12">
                    <div class="about-question">
                        <h2>{{$question->follower_count}}</h2><span>人关注</span>
                    </div>
                    @if(Auth::check())
                    <div class="">
                        <question-follow-button question="{{$question->id}}"> </question-follow-button>
                        <a class="btn btn-primary pull-right write-answer" href="#container">回答问题</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{$question->answer_count}}个答案 </div>
                @if($question->answer_count !== 0)
                <div class="panel-body">
                    @foreach($question->answers as $answer)
                        <div class="media answer-item">
                            <div class="media-body">
                                <div class="answer-info-avatar">
                                    <img src="{{$answer->user->avatar}}" />
                                </div>
                                <h4 class="media-heading answer-item-name">
                                    <a href="">
                                        {{$answer->user->name}}
                                    </a>
                                </h4>
                                <div class="answer-item-content">
                                    {!! $answer->body !!}
                                </div>
                            </div>
                            <div class="answer-item-time">
                                发布于 {{$answer->created_at->diffForHumans()}}
                            </div>
                            <div class="answer-item-actions">
                                <answer-vote-button answer="{{$answer->id}}" count="{{$answer->vote_count}}"> </answer-vote-button>
                                <comment commentable_type = 'answer' commentable_id="{{$answer->id}}" count="{{$answer->comment_count}}"></comment>
                                <div class="answer-item-action">
                                    <i class="fa fa-paper-plane fa-icon-sm"></i>
                                    分享
                                </div>
                                <div class="answer-item-action">
                                    <i class="fa fa-ellipsis-h"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                    <div class="panel-body question-empty-panel">
                        <i>╮(╯∀╰)╭</i>
                        <span class="empty-tips">暂时还没有答案</span>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading about-author">
                    <h5>提问者</h5>
                </div>
                <div class="panel-body">
                    <div class="media">
                        <div class="media-left"><img width="36" src="{{$question->user->avatar}}" alt="{{$question->user->name}}" /></div>
                        <div class="media-body">
                            <h4 class="media-heading">{{$question->user->name}}</h4>
                        </div>
                        <div class="user-statics">
                            <div class="statics-item text-center">
                                <div class="statics-text">提问</div>
                                <div class="statics-count">{{$question->user->ask_count}}</div>
                            </div>
                            <div class="statics-item text-center">
                                <div class="statics-text">关注的人</div>
                                <div class="statics-count">{{$question->user->following_count}}</div>
                            </div>
                            <div class="statics-item text-center">
                                <div class="statics-text">粉丝</div>
                                <div class="statics-count">{{$question->user->follower_count}}</div>
                            </div>
                        </div>
                    </div>
                    @if(Auth::check() && Auth::id()!==$question->user->id )
                        <div class="user-follow">
                            <user-follow-button user_id="{{$question->user_id}}"></user-follow-button>
                            <send-message user_id="{{$question->user_id}}" user_name="{{$question->user->name}}"></send-message>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-8 col-md-offset-1">
            <div class="panel panel-default">
                @if(Auth::check())
                    <div class="panel-heading">
                        <div class="answer-info-panel">
                            <div class="answer-info-avatar">
                                <img src="{{Auth::user()->avatar}}">
                            </div>
                            <div class="answer-content">{{Auth::user()->name}}</div>
                        </div>
                    </div>
                @endif
                <div class="panel-body">
                    @if(Auth::check())
                        <form action="{{route('answer.store',$question->id)}}" method="post">
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                <div id="container" name="body" type="text/plain" style="height:200px;">
                                    {!! old('body') !!}
                                </div>
                                @if ($errors->has('body'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <button type="submit" class="ui button teal pull-right">提交答案</button>
                        </form>
                    @else
                        <a href="/login" class="btn btn-success pull-right">登录提交答案</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('myjs')
    @include('vendor.ueditor.assets')
    <script type="text/javascript">
        var ue = UE.getEditor('container', {
            toolbars: [
                ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
            ],
            elementPathEnabled: false,
            enableContextMenu: false,
            autoClearEmptyNode:true,
            wordCount:false,
            imagePopup:false,
            initialFrameHeight:200,
            autotypeset:{ indent: true,imageBlockLine: 'center' }
        });
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>
@endsection
