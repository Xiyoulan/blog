@if(count($articles))
<div class="panel panel-default">
    <div class="panel-body">
        <div class ='article-list'>
            @foreach($articles as $article)
            <div class="media">
                @if($article->page_image)
                <div class="media-left">
                    <a href="{{ route('articles.show',$article->id) }} ">
                        <img class="media-object img-responsive img-thumbnail" src="{{ $article->page_image }}" alt="$article->title">
                    </a>
                </div>
                @endif
                <div class="media-body">
                    <h4 class="media-heading"> <a href="{{ route('articles.show',$article->id) }} ">{{ $article->title }}</a></h4>
                    {{ make_excerpt($article->content_html) }}
                </div>
                <div class="media-meta pull-right">
                    <span class="glyphicon glyphicon-time"></span>{{$article->created_at->toDateString() }} 
                    <span class="glyphicon glyphicon-comment"></span>{{$article->reply_count }}
                    <span class="glyphicon glyphicon-eye-open"></span>{{$article->view_count }}
                    @can('update',$article)
                        <a class="btn btn-xs btn-default" href="{{route('articles.edit',[$article->id]) }}">
                        <i class="glyphicon glyphicon-edit"></i>编辑</a>
                    @endcan
                       @can('destroy',$article)
                       <a class="btn btn-xs btn-default" onclick="event.preventDefault();
                                   $('#delete-form-{{$article->id}}').submit                           ();">
                       <i class="glyphicon glyphicon-trash"></i>删除</a>
                    <form id="delete-form-{{$article->id}}" action="{{ route('articles.destroy',$article->id) }}" method="POST" style="display: none;">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                    </form>
                    @endcan
                </div>
            </div> 
            @endforeach
            {!! $articles->appends(['tab'=>'article'])->links() !!}
        </div>

    </div>
</div>
@else
<div class="empty-block">没有发表任何话题 ~_~ </div>
@endif
