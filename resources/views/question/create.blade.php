@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">写下你的问题</div>

                    <div class="panel-body">
                        <form action="{{route('question.store')}}" method="post">
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <input type="text" name="title" class="form-control" placeholder="标题" value="{{old('title')}}">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                <script id="container" name="body" type="text/plain">{!! old('body') !!}</script>
                                @if ($errors->has('body'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('topics') ? ' has-error' : '' }}">
                                <select class="js-example-placeholder-multiple js-data-example-ajax form-control" multiple="multiple" name="topics[]">
                                </select>
                                @if ($errors->has('topics'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('topics') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="ui button teal pull-right">发布问题</button>
                        </form>
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

        $(document).ready(function() {
            function formatTopic (topic) {
                return "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" +
                topic.title ? topic.title : "Laravel"   +
                    "</div></div></div>";
            }

            function formatTopicSelection (topic) {
                return topic.title || topic.text;
            }
            $(".js-example-placeholder-multiple").select2({
                tags: true,
                placeholder: '选择相关话题',
                minimumInputLength: 1,
                ajax: {
                    url: '/api/topics',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function (data, params) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                templateResult: formatTopic,
                templateSelection: formatTopicSelection,
                escapeMarkup: function (markup) { return markup; }
            });
        });
    </script>
@endsection
