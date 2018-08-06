@extends('layouts.app')
@section('title',$article->title) 
@section('content')
<div class="widewrapper main">
    <div class="container">
        <div class="row">
            <div class="col-md-8 app-main">
                <article class="app-post">
                    @if($article->page_image)
                    <header>

                        <div class="lead-image">
                            <img src="{{ $article->page_image }}" alt="{{ $article->title }}" class="img-responsive img-thumbnail">
                        </div>
                    </header>
                    @endif
                    <div class="body">
                        <h1 class="article-title"><center>{{ $article->title }}</center></h1>
                        <div class="meta">
                            <i class="glyphicon glyphicon-user"></i> <a href="{{ route('users.show',$article->author->id) }}">{{ $article->author->name }}</a>
                            <i class="glyphicon glyphicon-calendar"></i><a href="#">{{ $article->created_at->toDateString() }}</a>
                            <i class="glyphicon glyphicon-eye-open"></i><span class="data"><a>{{ $article->view_count }}</a></span>
                            <i class="glyphicon glyphicon-comment"></i><span class="data"><a href="#comments">{{ $article->reply_count }}</a></span>
                        </div>
                        <hr>
                        <div class="article-body">
                            {!! $article->content_html !!}
                        </div>
                    </div>
                </article>
                <hr>   
                <!--  comment begin-->
                <div id="comments" class="comment-box">
                    @include('articles._comments')
                </div>
                @auth
                @include('articles._create_comments')
                @else
                <center style="font-size: 14px;margin-bottom: 30px; "><a href="{{route('login')}}">登录</a>后才可评论~</center>
                @endauth
            </div>
            @include('commons._aside')
        </div>
    </div>
</div>
@include('articles._create_child_comments')
@endsection
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/simditor/simditor.css') }}">
<!--<link rel="stylesheet" type="text/css" href="{{asset('css/jquery.atwho.css')}}" >-->
@endsection
@section('scripts')
<script type="text/javascript"  src="{{ asset('js/vendor/module.js') }}"></script>
<script type="text/javascript"  src="{{ asset('js/vendor/hotkeys.js') }}"></script>
<script type="text/javascript"  src="{{ asset('js/vendor/uploader.js') }}"></script>
<script type="text/javascript"  src="{{ asset('js/vendor/simditor.js') }}"></script>
<!--<script type="text/javascript"  src="{{ asset('js/jquery.caret.js') }}"></script>
<script type="text/javascript"  src="{{ asset('js/jquery.atwho.js') }}"></script>-->
<script type="text/javascript">
//    $(document).ready(function(){
//        var editor = new Simditor({
//            textarea: $('#editor'),
//        });
//    });
$(document).ready(function () {
    var editor = new Simditor({
        textarea: $('#editor'),
        toolbar: [
            'title',
            'bold',
            'italic',
            'underline',
            'strikethrough',
            'fontScale',
            'color',
            'ol',
            'ul',
            'blockquote',
            'code',
            'table',
            'link',
            'image',
            'hr',
            'indent',
            'outdent',
            'alignment'
        ],
        upload: {
            url: '{{ route('replies.uploadImage') }}',
            params: {_token: '{{ csrf_token() }}'},
            fileKey: 'upload_file',
            connectionCount: 3,
            leaveConfirm: '文件上传中，关闭此页面将取消上传。'
        },
        pasteImage: true,
    });
});
function showMore(obj) {
    event.stopPropagation();
    obj.siblings('.child-reply-box').find('.child-reply').removeClass('hidden');
    obj.addClass('hidden');
    obj.siblings('button').removeClass('hidden');
}
function hiddenReplies(obj) {
    event.stopPropagation();
    obj.siblings('.child-reply-box').find('.child-reply').addClass('hidden');
    obj.addClass('hidden');
    obj.siblings('button').html("展开评论&nbsp;<span class='glyphicon glyphicon-chevron-down'></span>").removeClass('hidden');
}
$('.reply-btn').on('click', function (event) {
    //event.stopPropagation();
    //置空
    $('#reply-content').val('');
    $('#reply_to_id').val('');
    $('#parent_id').val('');
    var parent_id = $(this).attr('data-parant-id');
    var reply_to_id = $(this).attr('data-reply-to-id');
    var reply_to_name = $(this).parent('.comment-meta').parent('.media-body').find('.reply-from-name').html();
    //console.log(reply_to_name);
    if (parent_id) {
        $('#parent_id').val(parent_id);
    }
    if (reply_to_id) {
        $('#reply_to_id').val(reply_to_id);
    }
    $('#reply-to-name').html(reply_to_name);
    $('#reply-content').attr('placeholder', '@' + reply_to_name + ':');
    $('#reply-modal').modal('show');

});
function submitReply() {
    var content = $('#reply-content').val();
    if (!content) {
        $('#warning-info').removeClass('hidden');
        return;
    }
    ;
    $.ajax({
        type: 'POST',
        url: "{{ route('replies.store') }}",
        data: $('#reply-form').serialize(),
        success: function (msg) {
            //置空
            $('#reply-content').val('');
            $('#reply_to_id').val('');
            $('#parent_id').val('');
            $('#reply-modal').modal('hide');
            //console.log(msg);

            window.location.href = window.location.search + '#reply' + msg.id;
            window.location.reload();
        }
    });

}
//$('#reply-textarea').atwho({
//    at: "@",
//    callbacks: {
//        remoteFilter: function (query, callback) {
//            $.getJSON("/usersjson", {key: query}, function (data) {
//                callback(data)
//            });
//        }
//    }
//});
</script>
@endsection
