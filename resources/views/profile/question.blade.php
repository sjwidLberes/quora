@extends('profile.main')
@section('profile-content')

    <div class="profileMain-content">
        @foreach($user->questions as $question)
            <div class="list-item">
                <div class="col-md-1">
                    @if($question->answer_count>0)
                        <span class="ui label green"> {{$question->answer_count}} 回答</span>
                    @else
                        <span class="ui label yellow"> {{$question->answer_count}} 回答</span>
                    @endif
                </div>
                <div class="col-md-9">
                    <a href="{{route('question.show',$question->id)}}">{{$question->title}}</a>
                </div>
                <div class="col-md-2">
                    <span>{{$question->created_at->diffForHumans()}}</span>
                </div>
            </div>
        @endforeach
    </div>
@endsection