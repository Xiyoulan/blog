@extends('layouts.app')

@section('content')
<div class="widewrapper main">
    <div class="container">
        <div class="row">
            <div class="col-md-8 app-main">
                @if (isset($category))
                <div class="alert alert-info" role="alert">
                    {{ $category->name }} ：{{ $category->description }}
                </div>
                @endif
                <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li role="presentation" class="{{ active_class( ! if_query('order', 'recent') && ! if_query('order', 'no-reply')) }}"><a href="{{ Request::url() }}?order=default">最近回复</a></li>
                            <li role="presentation" class="{{ active_class(  if_query('order', 'recent')) }}"><a href="{{ Request::url() }}?order=recent">最新发布</a></li>
                            <li role="presentation" class="{{ active_class(  if_query('order', 'no-reply')) }}"><a href="{{ Request::url() }}?order=no-reply">消灭零回复</a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        @if(count($articles))
                        @foreach($articles as $article)
                        <div class="media">
                            <div class="media-left">
                                <a href="{{ route('users.show',$article->author->id) }}">
                                    <img class="media-object img-thumbnail img-responsive" style="max-width: 64px;"src="{{ $article->author->avatar }}" alt="{{ $article->author->name }}" title="{{ $article->author->name }}">
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="media-heading"><a href="{{ route('articles.show',$article->id) }}">{{ $article->title }}</a>
                                    <span class="meta pull-right">
                                        <a href="{{ route('categories.show', $article->category->id) }}" title="{{ $article->category->name }}">
                                            <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                                            {{ $article->category->name }}
                                        </a>
                                        <span> • </span>
                                        <a href="{{ route('users.show', [$article->user_id]) }}" title="{{ $article->author->name }}">
                                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                            {{ $article->author->name }}
                                        </a>
                                        <span> • </span>
                                        <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                        <span class="timeago" title="最后活跃于">{{ datetime_for_humans($article->updated_at) }}</span>
                                        <span> • </span>
                                        <span class="glyphicon glyphicon-comment"></span>
                                        <span>{{ $article->reply_count }}</span>
                                    </span>
                                </div>
                                {{ make_excerpt($article->content_html,100) }}
                            </div>
                            @if($article->lastReplyUser)
                            <span class="pull-right last-reply-user">
                                最后活跃:
                                <a href="{{ route('users.show', [$article->lastReplyUser->id]) }}" title="{{ $article->lastReplyUser->name }}">{{ $article->lastReplyUser->name }}</a>
                            </span>
                            @endif  
                        </div>
                        <hr>                   
                        @endforeach
                        {!! $articles->appends(Request::only(['order']))->links() !!}
                        @else
                        o(╯□╰)o  &nbsp; 空空如也~
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @include('commons._aside')
            </div>
        </div>
    </div>
</div>
@endsection
