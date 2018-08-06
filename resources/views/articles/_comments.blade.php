@foreach($replies as $reply)
<div class="media">
    <div class="media-left">
        <a href="{{ route('users.show',$reply->replyFrom->id) }}">
            <img class="media-object img-circle img-responsive" src="{{$reply->replyFrom->avatar}}" alt="{{ $reply->replyFrom->name }}">
        </a>
    </div>
    <div class="media-body">
        <h4 class="media-heading" id="reply{{ $reply->id }}"><a href="{{ route('users.show',$reply->replyFrom->id) }}" class="reply-from-name">{{ $reply->replyFrom->name }}</a>:<span class="pull-right" style="color: #999;font-size: 8px;">#</span></h4>
        <div class="comment-body parent-comment-body">
            {!! $reply->content !!}
        </div>
        <div class="comment-meta"><time datetime="" class="pull-left"><i class='glyphicon glyphicon-time'></i>{{ $reply->created_at }}</time>
            @can('destroy',$reply)
            <form id="delete-form-{{$reply->id}}" action="{{ route('replies.destroy',$reply->id) }}" method="post">
                {{ csrf_field()}}
                {{ method_field('delete') }}
            </form>
            &nbsp;|&nbsp;<button class="btn btn-default btn-xs"  onclick="return confirm('确认删除回复?')" onclick="event.stopPropagation();
                        if (confirm('确认删除回复?')){
                $('#delete-form-{{ $reply->id }}').submit();
                    }">删除</button>

            @endcan
            @auth
            |&nbsp;<button class="btn btn-default btn-xs reply-btn" data-parant-id="{{ $reply->id }}">回复</button>
            @endauth
        </div>
        @if(count($reply->childReplies))
        <button type="button" class="btn btn-default btn-xs more-reply hidden" onclick="hiddenReplies($(this))">收起评论&nbsp;<span class="glyphicon glyphicon-chevron-up"></span></button>
        <div class="child-reply-box">
            @foreach($reply->childReplies as $childReply)
            <div class="media child-reply {{$loop->iteration <=3?'':'hidden' }}">
                <div class="media-left">
                    <a href="{{ route('users.show',$childReply->replyFrom->id) }}">
                        <img class="media-object img-circle img-responsive" src="{{$childReply->replyFrom->avatar}}" alt="{{ $childReply->replyFrom->name }}">
                    </a>
                </div>
                <div class="media-body">
                    <div class="comment-body" id="reply{{ $childReply->id }}">
                        <a href="{{ route('users.show',$childReply->replyFrom->id) }}" class="reply-from-name">{{$childReply->replyFrom->name}}</a>
                        @if($childReply->replyTo)
                        回复 <a href="{{ route('users.show',$childReply->replyTo->id) }}">{{ $childReply->replyTo->name }}</a>
                        @endif
                        :
                        {{ $childReply->content }}
                    </div>
                    <div class="comment-meta"><time datetime=""class="pull-left"><i class='glyphicon glyphicon-time hidden-xs'></i>{{$childReply->created_at}}</time>
                        @can('destroy',$childReply)
                        <form id="delete-form-{{ $childReply->id }}" action="{{ route('replies.destroy',$childReply->id) }}" method="post">
                            {{ csrf_field()}}
                            {{ method_field('delete') }}
                        </form>
                        &nbsp;|&nbsp;<button class="btn btn-default btn-xs"  onclick=" event.stopPropagation();
                                    if (confirm('确认删除回复?')){
                            $('#delete-form-{{ $childReply->id }}').submit();
                                }" >删除</button>

                        @endcan
                        @auth
                        |&nbsp;<button class="btn btn-default btn-xs reply-btn" data-parant-id="{{ $reply->id }}" data-reply-to-id="{{ $childReply->replyFrom->id }} ">回复</button>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if(count($reply->childReplies)>3)
        <button type="button" class="btn btn-default btn-xs more-reply" onclick="showMore($(this))">还有{{count($reply->childReplies)-3}}条评论, 点击加载更多&nbsp;<span class="glyphicon glyphicon-chevron-down"></span></button>
        @endif
        @endif
        <!--                <ul class="pagination pagination-sm">
                        <li>
                            <a href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li>
                            <a href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>-->
    </div>
</div>
@endforeach
<center>{{ $replies->links() }}</center>
