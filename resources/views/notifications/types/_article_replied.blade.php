<div class="media">
    <div class="media-left">
        <a href="{{ route('users.show', $notification->data['from_id']) }}">
            <img class="media-object img-thumbnail" alt="{{ $notification->data['from_name'] }}" src="{{ $notification->data['from_avatar'] }}"  style="width:48px;height:48px;"/>
        </a>
    </div>

     <div class="media-body">
        <div class="media-heading">
            <a href="{{ route('users.show', $notification->data['from_id']) }}">{{ $notification->data['from_name'] }}</a>
            评论了话题:
            <a href="{{ route('articles.show',$notification->data['article_id']) }}">{{ $notification->data['article_title'] }}</a>

            <span class="meta pull-right" title="{{ $notification->created_at }}">
                <span class="glyphicon glyphicon-clock" aria-hidden="true"></span>
                {{ $notification->created_at->diffForHumans() }}
            </span>
        </div>
            {{make_excerpt($notification->data['reply_content']) }}
    </div>
</div>
<hr>

