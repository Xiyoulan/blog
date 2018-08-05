@extends('layouts.app')

@section('content')
<div class="widewrapper main">
    <div class="container">
        <div class="row">
            <div class="col-md-8 app-main">

                @foreach($articles as $article)
                @if($loop->iteration%2==1)
                <div class="row">
                    @endif

                    <div class="col-md-6 col-sm-6">
                        <article class=" app-teaser">
                            <header>
                                 @if($article->page_image)
                                <img src="{{ $article->page_image }}" class="img-responsive" alt="{{ $article->title }}">
                                 @endif
                                <h3><a href="{{ route('articles.show',$article->id) }}">{{ $article->title }}</a></h3>
                                <span class="meta">Posted on {{ $article->created_at->toDateString() }} by <a href="{{ route('users.show',$article->author->id) }}"><span class="glyphicon glyphicon-user"></span>  {{$article->author->name}}</a></span>
                                <hr>
                            </header>
                            <div class="body">
                                {{make_excerpt($article->content_html)}}
                            </div>
                            <div class="clearfix">
                                <a href="{{ route('articles.show',$article->id) }}" class="btn btn-clean-one">Read more</a>
                            </div>
                        </article>
                    </div>
                    @if($loop->iteration%2==0)
                </div>
                @endif

                @endforeach

                <div class="paging">
                    <a href="#" class="older"><i>more...</i></a>
                </div>
            </div>
            @include('commons._aside')
        </div>
    </div>
</div>

@endsection
