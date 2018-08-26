<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Carbon\Carbon;
use App\Handlers\ImageUploadHandler;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(Request $request)
    {
        $articles = Article::with('author', 'category', 'lastReplyUser','tags')->top()->withOrder($request->order)->paginate(20);
        return view('articles.index', compact('articles'));
    }

    public function show(Article $article)
    {
        $replies = $article->replies()->with(
                        ['replyFrom', 'childReplies' => function($query) {
                                return $query->with('replyFrom', 'replyTo')->ancient();
                            }])->parentNode()->ancient()->paginate(config('application.replies_per_page'));
        $article->addViewCount();
        $category =$article->category;
        $tags = $article->tags;
        return view('articles.show', compact('article', 'replies','category','tags'));
    }

    public function create(Article $article)
    {
        $this->authorize('create', $article);
        $categories = Category::All();
        return view('articles.create_and_edit', compact('categories', 'article'));
    }

    public function store(ArticleRequest $request, Article $article, Tag $tag, ImageUploadHandler $uploader)
    {
        $this->authorize('create', $article);
        $article->fill($request->only(['content_html', 'title', 'category_id']));
        $article->user_id = \Auth::id();
        if ($request->page_image) {
            $result = $uploader->save($request->page_image, 'articles', \Auth::id(), 750);
            if ($result) {
                $article->page_image = $result['path'];
            }
        }
        $article->created_at = Carbon::now();
        $article->updated_at = Carbon::now();
        $article->save();
        $tags = $request->input('tags', []);
        $article->syncTags($tags);
        return redirect()->route('articles.show', [$article->id])->with('success', '成功创建话题!');
    }

    public function edit(Article $article)
    {
        $this->authorize('update', $article);
        $categories = Category::All();
        $article->load('tags');
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
        $article->updated_at = Carbon::now();
        $article->update();
        $tags = $request->input('tags', []);
        $article->syncTags($tags);
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
