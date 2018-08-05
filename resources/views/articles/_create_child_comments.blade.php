<div class="modal fade" id ="reply-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">回复 <span id='reply-to-name'></span>:</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning hidden" id='warning-info' role="alert">
                    <button type="button" class="close" aria-label="Close" onclick="$(this).parent('.alert').addClass('hidden')"><span aria-hidden="true">&times;</span></button>
                    <span class="info-content">内容不能为空!</span>
                </div>
                <form action="{{ route('replies.store') }}" id="reply-form" method="POST"  accept-charset="UTF-8">
                    {{ csrf_field()}}
                    <input type="hidden" id="article_id" name="article_id" value="{{ $article->id }}">
                    <input type="hidden" id="parent_id" name="parent_id" value="">
                    <input type="hidden" id="reply_to_id" name="reply_to_id" value="">
                    <div class="form-group">
                        <textarea  name="content" class="form-control" id="reply-content" rows="3" placeholder="在此输入回复内容" required></textarea>
                    </div>
                    <button type="button" id="reply-submit" onclick="submitReply()" class="btn btn-danger">发布</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>

                </form>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
