<div class="col-lg-9 col-md-8 col-sm-7 app-main">
    <ul class="nav nav-tabs user-nav" id="user-tab">
        <li role="presentation" class="{{ active_class(if_route('users.show')&&!if_query('tab','comment')&&!if_query('tab','edit'))}}"><a href="{{route('users.show',$user->id)}}">{{Auth::id()==$user->id?"我的话题":"Ta 的话题"}}</a></li>
        <li role="presentation" class="{{ active_class(if_route('users.show')&&if_query('tab','comment'))}}"><a href="{{route('users.show',[$user->id,'tab'=>'comment'])}}">评论/回复</a></li>
        @can('update',$user)
        <li role="presentation" class="{{ active_class(if_route('users.show')&&if_query('tab','edit'))}}"><a href="#edit" data-toggle="tab">编辑信息</a></li>
        @endcan
        <li role="presentation" class="dropdown visible-xs">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                更多 <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                @if(Auth::id()==$user->id)
                <li><a href="#">收藏</a></li>
                <li><a href="#">通知</a></li>
                @endif
                <li><a href="#">粉丝</a></li>
                <li><a href="#">关注</a></li>
                @if(Auth::id()==$user->id)
                <li role="separator" class="divider"></li>
                <li><a href="{{ route('articles.create') }}">发贴</a></li>
                @endif
            </ul>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        @if(if_route('users.show')&&!if_query('tab','comment')&&!if_query('tab','edit'))
        <div role="tabpanel" class="tab-pane {{ active_class(if_route('users.show'))}}" id="article">
            @include('users._article',['articles'=>$user->articles()->recent()->paginate(5)])
        </div>
        @endif
        @if(if_route('users.show')&&if_query('tab','comment'))
        <div role="tabpanel" class="tab-pane {{ active_class(if_route('users.show')&&if_query('tab','comment'))}}" id="comment">
            @include('users._comment',['replies'=>$user->replies()->with('article')->recent()->paginate(20)])
        </div>
        @endif
        @can('update',$user)
        <div role="tabpanel" class="tab-pane {{ active_class(if_route('users.show')&&if_query('tab','edit'))}}" id="edit">
            @include('users._edit')
        </div>
        @endcan
    </div>

</div>

