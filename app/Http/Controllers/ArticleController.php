<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Handlers\ImageUploadHandler;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        return view('articles.index');
    }

    public function show(Article $article)
    {
        $replies = $article->replies()->with(
                        ['replyFrom', 'childReplies' => function($query) {
                                return $query->with('replyFrom', 'replyTo')->ancient();
                            }])->parentNode()->ancient()->paginate(10);
        $article->increment('view_count', 1);
        return view('articles.show', compact('article', 'replies'));
    }

    public function create(Article $article)
    {
        $categories = Category::All();
        return view('articles.create_and_edit', compact('categories', 'article'));
    }

    public function store(ArticleRequest $request, Article $article, ImageUploadHandler $uploader)
    {
        $article->fill($request->only(['content_html', 'title', 'category_id']));
        $article->user_id = \Auth::id();
        if ($request->page_image) {
            $result = $uploader->save($request->page_image, 'articles', \Auth::id(), 750);
            if ($result) {
                $article->page_image = $result['path'];
            }
        }
        $article->save();
        return redirect()->route('articles.show', [$article->id])->with('success', '成功创建话题!');
    }

    public function edit(Article $article)
    {
        $this->authorize('update', $article);
        $categories = Category::All();
        return view('articles.create_and_edit', compact('categories', 'article'));
    }

    public function update(ArticleRequest $request, Article $article, ImageUploadHandler $uploader)
    {
        $this->authorize('update', $article);
        $article->fill($request->only(['content_html', 'title', 'category_id']));
        $article->user_id = \Auth::id();
        if ($request->page_image) {
            $result = $uploader->save($request->page_image, 'articles', \Auth::id(), 750);
            if ($result) {
                $article->page_image = $result['path'];
            }
        }
        $article->update();
        return redirect()->route('articles.show', [$article->id])->with('success', '成功创建话题!');
    }

    public function destroy(Article $article)
    {
        $this->authorize('destroy', $article);
        $article->delete();
        return back()->with('info', '成功删除话题!');
    }

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success' => false,
            'msg' => '上传失败!',
            'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        $file = $request->upload_file;
        if ($file) {
            // 保存图片到本地
            $result = $uploader->save($request->upload_file, 'articles', \Auth::id(), 750);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg'] = "上传成功!";
                $data['success'] = true;
            }
        }
        return $data;
    }

}
