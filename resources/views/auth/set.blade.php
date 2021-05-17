@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">控制面板</div>

                    <div class="panel-body">
                        <avatar avatar="{{Auth::user()->avatar}}"></avatar>
                        <change-password></change-password>
                        <edit-profile place="{{Auth::user()->setting['place']}}"
                                      github="{{Auth::user()->setting['github']}}"
                                      site="{{Auth::user()->setting['site']}}"
                                      introduction="{{Auth::user()->setting['introduction']}}"></edit-profile>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
