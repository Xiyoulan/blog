<div class="panel panel-default">

    <div class="panel-body">
        <h5 class="text-center">
            <i class="glyphicon glyphicon-edit"></i>
            发表你的想法~
        </h5>
        <hr>
       
            <form action="{{ route('replies.store') }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="article_id" value="{{ $article->id }}">
                <div class="form-group">
                    <textarea  name="content" class="form-control" id="editor" rows="3" placeholder="在此输入评论内容~" required></textarea>
                </div>
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 提交</button>
            </form>
    </div>
</div>
