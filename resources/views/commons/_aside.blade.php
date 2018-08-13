<div class="panel panel-default hidden-sm hidden-xs">
    <div class="panel-heading">热门推荐</div>
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

<div class="panel panel-default hidden-sm hidden-xs">
    <div class="panel-heading">标签</div>
    <div class="body clearfix">
        <ul class="tags">
            <li><a href="#">HTML5</a></li>
            <li><a href="#">CSS3</a></li>
            <li><a href="#">COMPONENTS</a></li>
            <li><a href="#">TEMPLATE</a></li>
            <li><a href="#">PLUGIN</a></li>
            <li><a href="#">BOOTSTRAP</a></li>
            <li><a href="#">TUTORIAL</a></li>
            <li><a href="#">UI/UX</a></li>                            
        </ul>
    </div>
</div>
