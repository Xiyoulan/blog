@extends('layouts.app')
@section('title','新建话题') 
@section('content')
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">

            <div class="panel-body">
                <h2 class="text-center">
                    <i class="glyphicon glyphicon-edit"></i>
                    @if($article->id)
                    编辑话题
                    @else
                    新建话题
                    @endif
                </h2>

                <hr>

                @include('commons._error')

                @if($article->id)
                <form action="{{ route('articles.update', $article->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT">
                    @else
                    <form action="{{ route('articles.store') }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                        @endif

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="article-title"><span style="color:red;">*</span> 标 题:</label>
                            <input id ='article-title' class="form-control" type="text" name="title" value="{{ old('title', $article->title ) }}" placeholder="请填写标题" required/>
                        </div>

                        <div class="form-group">
                            <label for="category_id"><span style="color:red;">*</span> 分 类:</label>
                            <select id="category_id" class="form-control" name="category_id" required>
                                <option value="" hidden disabled selected>请选择分类</option>
                                @foreach ($categories as $value)
                                <option value="{{ $value->id }}"  {{ old('category_id', $article->category_id )  == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="page-image">封面图片:</label>
                            <input id ='page-image' type="file" name="page_image" />
                            @if($article->page_image)
                            <img id="article-page-image" class='img-responsive img-thumbnail' src="{{$article->page_image}}">
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="tag">标签:</label>
                            <select id="select-tags" class="form-control" name="tags[]" multiple="multiple">
                            
                             @foreach(old('tags', $article->tags->pluck('name')->toArray()) as $tag)
                             <option value="{{ $tag }}" selected>
                                 {{ $tag }}
                             </option>
                             @endforeach
                        
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editor"><span style="color:red;">*</span> 内 容:</label>
                            <textarea  name="content_html" class="form-control" id="editor" rows="3" placeholder="请填入至少10个字符的内容。" required>{{ old('content_html', $article->content_html ) }}</textarea>
                        </div>

                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 保存</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<link href="https://cdn.bootcss.com/select2/4.0.6-rc.1/css/select2.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('css/simditor/simditor.css') }}">
@stop

@section('scripts')
<script src="https://cdn.bootcss.com/select2/4.0.6-rc.1/js/select2.min.js"></script>
<script type="text/javascript"  src="{{ asset('js/vendor/module.js') }}"></script>
<script type="text/javascript"  src="{{ asset('js/vendor/hotkeys.js') }}"></script>
<script type="text/javascript"  src="{{ asset('js/vendor/uploader.js') }}"></script>
<script type="text/javascript"  src="{{ asset('js/vendor/simditor.js') }}"></script>

<script>
//    $(document).ready(function(){
//        var editor = new Simditor({
//            textarea: $('#editor'),
//        });
//    });
$(document).ready(function () {
    $("#select-tags").select2({
        ajax: {
            url: "/tags",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    keyword: params.term, // search term
                };
            },
            processResults: function (result) {
                return {

                    results: $.map(result.data, function (d) {
                        d.id = d.idField;
                        d.text = d.textField;
                        return d;
                    })
                };
            },
            cache: true
        },
        language: "zh-CN",
        placeholder: '支持搜索选择，也支持自定义添加',
        tags: true,
        maximumSelectionLength: 10  //最多能够选择的个数
    });
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
            url: '{{ route('articles.uploadImage') }}',
            params: {_token: '{{ csrf_token() }}'},
            fileKey: 'upload_file',
            connectionCount: 3,
            leaveConfirm: '文件上传中，关闭此页面将取消上传。'
        },
        pasteImage: true,
    });
});
</script>

@stop


