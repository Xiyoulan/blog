@if (count($replies))

<ul class="list-group">
    @foreach ($replies as $reply)
    <li class="list-group-item">
        <a href="{{ $reply->link()  }}">
            {{ $reply->article->title }}
        </a>

        <div class="reply-content" style="margin: 6px 0;">
            {{make_excerpt($reply->content) }}
        </div>

        <div class="meta">
            <span class="glyphicon glyphicon-time" aria-hidden="true"></span> 回复于 {{ $reply->created_at->diffForHumans() }}
        </div>
    </li>
    @endforeach
</ul>
{!! $replies->appends(['tab'=>'comment'])->render() !!}
@else
<div class="empty-block">暂无数据 ~_~ </div>
@endif

{{-- 分页 --}}
