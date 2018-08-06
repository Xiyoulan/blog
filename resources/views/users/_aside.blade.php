<aside class="col-lg-3 col-md-4 col-sm-5  app-aside  user-aside">
    <div class="panel panel-default hidden-xs">   
        <div class="panel-heading">
            <div class="media">
                <div class="media-left">
                    <a href="{{route('users.show',$user->id) }}">
                        <img class="media-object img-circle img-responsive" src="{{ $user->avatar }}" alt="{{ $user->name }}">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">{{ $user->name }}</h4>
                    <p class="dio">
                        <span style="color: #222">简介:</span>{{$user->introduction?:"这个人很懒,什么都没留下~"}}
                    </p>
                </div>
                注册于 <span class="activated-time">{{$user->created_at->diffForHumans()}}</span>
                活跃于 <span class="activated-time">1周前</span>
                @auth
                @if(Auth::id()!=$user->id)
                <button class="btn btn-info btn-sm btn-block"><span class="glyphicon glyphicon-plus"></span> 关注 ta</button>
                @endif
                @endauth
            </div>
        </div>
        <div class="panel-body">
            <div class="list-group">
                @if(Auth::id()==$user->id)
                <a href="{{ route('articles.create') }}" class="list-group-item "><span class="glyphicon glyphicon-plus pull-right"></span><span class="glyphicon glyphicon-pencil"></span>创作新话题</a>
                <a href="#" class="list-group-item "><span class="badge">0</span><span class="glyphicon glyphicon-folder-open"></span>我收藏的话题</a>
                @endif
                <a href="{{ route('users.show',[$user->id,'tab'=>'articles']) }}" class="list-group-item "><span class="badge">{{ $user->articles_count }}</span><span class="glyphicon glyphicon-list-alt"></span>{{Auth::id()==$user->id?"我发布的话题":"Ta 发布的话题"}}</a>
                <a href="{{ route('users.show',[$user->id,'tab'=>'comment']) }}" class="list-group-item "><span class="badge">{{ $user->replies_count }}</span><span class="glyphicon glyphicon-comment"></span>{{Auth::id()==$user->id?"我的评论/回复":"Ta 的评论/回复"}}</a>
                @if(Auth::id()==$user->id)
                <a href="#" class="list-group-item "><span class="badge">0</span><span class="glyphicon glyphicon-envelope"></span>通知我的消息</a>
                @endif
                <a href="#" class="list-group-item "><span class="badge">0</span><span class="glyphicon glyphicon-eye-open"></span>{{Auth::id()==$user->id?"我关注的用户":"Ta 关注的用户"}}</a>
                <a href="#" class="list-group-item "><span class="badge">0</span><span class="glyphicon glyphicon-heart"></span>{{Auth::id()==$user->id?"关注我的用户":"关注 Ta 的用户"}}</a>

            </div>
        </div>
    </div>
</aside>


