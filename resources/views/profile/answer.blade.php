@extends('profile.main')
@section('profile-content')
    <div class="profileMain-content">
        @foreach($user->answers as $answer)
            <div class="list-item">
                <div class="col-md-10">
                    <a href="">{{$answer->question->title}}</a><br />
                    {{mb_substr(strip_tags($answer->body),0,66,"utf-8")}}
                </div>
                <div class="col-md-2">
                    <span>{{$answer->created_at->diffForHumans()}}</span>
                </div>
            </div>
        @endforeach
    </div>
@endsection