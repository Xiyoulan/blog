@extends('layouts.app')

@section('title','收藏')

@section('content')
    <div class="widewrapper main">
        <div class="container">
            <div class="row">
                <div class="col-md-9 app-main">
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading">
                            <h3>收藏的话题 </h3>
                        </div>
                        <div class="panel-body">
                            @if(count($articles))
                                @foreach($articles as $article)
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="{{ route('users.show',$article->author->id) }}">
                                                <img class="media-object img-thumbnail img-responsive" src="{{ $article->author->avatar }}" alt="{{ $article->author->name }}" title="{{ $article->author->name }}">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <div class="media-heading">
                                                @if($article->is_top)
                                                    <span class="label label-info">置顶</span>
                                                @endif
                                                @if($article->is_recommended)
                                                    <span class="label label-danger">精</span>
                                                @endif
                                                <a href="{{ route('articles.show',$article->id) }}">
                                                    {{ $article->title }}</a>
                                                <span class="meta pull-right">
                                        <a href="{{ route('categories.show', $article->category->id) }}" class="hidden-xs" title="{{ $article->category->name }}">
                                            <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                                            {{ $article->category->name }}
                                        </a>
                                        <span class="hidden-xs"> • </span>
                                        <a href="{{ route('users.show', [$article->user_id]) }}" title="{{ $article->author->name }}">
                                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                            {{ make_excerpt($article->author->name,15) }}
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
                                        @if(count($article->tags)>0)
                                            <span class="pull-left article-tags hidden-xs"><span class="glyphicon glyphicon-tags"></span>&nbsp;标签:&nbsp;
                                                @foreach($article->tags as $item)
                                                    <a href="{{ route('tags.show',$item->name) }}">{{$item->name}}</a>
                                                    @if(!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                            </span>
                                        @endif
                                    </div>
                                    <hr>
                                @endforeach
                                {!! $articles->links() !!}
                            @else
                                o(╯□╰)o  &nbsp; 空空如也~
                            @endif
                        </div>
                    </div>
                </div>
                @include('users._aside')
            </div>
        </div>
    </div>
@endsection