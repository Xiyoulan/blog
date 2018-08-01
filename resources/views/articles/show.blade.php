@extends('layouts.app')
@section('title',$article->title) 
@section('content')
<div class="widewrapper main">
    <div class="container">
        <div class="row">
            <div class="col-md-8 app-main">
                <article class="app-post">
                    <header>

                        <div class="lead-image">
                            <img src="{{ $article->page_image }}" alt="{{ $article->title }}" class="img-responsive">
                        </div>
                    </header>
                    <div class="body">
                        <h1 class="article-title">{{ $article->title }}</h1>
                        <div class="meta">
                            <i class="glyphicon glyphicon-user"></i> <a href="{{ route('users.show',$article->author->id) }}">{{ $article->author->name }}</a>
                            <i class="glyphicon glyphicon-calendar"></i><a href="#">{{ $article->published_at->toDateString() }}</a>
                            <i class="glyphicon glyphicon-eye-open"></i><span class="data"><a>{{ $article->view_count }}</a></span>
                            <i class="glyphicon glyphicon-comment"></i><span class="data"><a href="#comments">{{ $article->reply_count }}</a></span>
                        </div>
                        <hr>
                        {!! $article->content_html !!}
                    </div>
                </article>
                <hr>   
                <!--  comment begin-->
                <div id="comments" class="comment-box">
                    @include('articles._comments')
                </div>
                <aside class="create-comment" id="create-comment">
                    <hr>    
                    <form action="#" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="name" id="comment-name" placeholder="Your Name" class="form-control input-lg">    
                            </div>
                            <div class="col-md-6">
                                <input type="email" name="email" id="comment-email" placeholder="Email" class="form-control input-lg">    
                            </div>
                        </div>

                        <input type="url" name="name" id="comment-url" placeholder="Website" class="form-control input-lg">

                        <textarea rows="10" name="message" id="comment-body" placeholder="Your Message" class="form-control input-lg"></textarea>

                        <div class="buttons clearfix">
                            <button type="submit" class="btn btn-xlarge btn-clean-one">提交</button>
                        </div>
                    </form>
                </aside>
            </div>
            @include('commons._aside')
        </div>
    </div>
</div>

@endsection

