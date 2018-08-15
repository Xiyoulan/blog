<div class="panel panel-default hidden-sm hidden-xs">
    <div class="panel-heading">热门标签</div>
    <div class="body clearfix">
        <ul class="tags">
            @foreach($hot_tags as $tag)
            <li><a href="{{ route('tags.show',$tag->name) }}">{{ $tag->name }}</a></li>
            @endforeach
        </ul>
    </div>
</div>
<div class="panel panel-default hidden-sm hidden-xs">
    <div class="panel-heading">推荐</div>
    <div class="panel-body">
        <ul class="list-group">
            @foreach($recommended_articles as $article)
            <a href="{{route('articles.show',$article->id)}}" class="list-group-item">{{ make_excerpt($article->title,30) }}</a>
            @endforeach
        </ul>
    </div>
</div>

<div class="panel panel-default hidden-sm hidden-xs">
    <div class="panel-heading">热门浏览</div>
    <div class="panel-body">
        <ul class="list-group">
            @foreach($view_articles as $article)
            <a href="{{route('articles.show',$article->id)}}" class="list-group-item">  <span class="badge">{{ $article->view_count }}</span>{{ make_excerpt($article->title,30) }}</a>
            @endforeach
        </ul>
    </div>
</div>

