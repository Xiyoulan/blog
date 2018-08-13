<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Admin\Extensions\RestoreArticle;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use \App\Models\Link;

class ArticleController extends Controller
{

    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

                    $content->header('话题管理');
                    $content->body($this->grid());
                });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

                    $content->header('编辑话题');
                    $content->body($this->form()->edit($id));
                });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

                    $content->header('header');
                    $content->description('description');

                    $content->body($this->form());
                });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Article::class, function (Grid $grid) {
                    $grid->model()->withTrashed();
                    $grid->id('ID')->sortable();
                    $grid->title('标题')->display(function($title) {
                        //
                        return str_limit($title, 20);
                    });
                    $grid->author()->name('作者');
                    $grid->category()->name('分类');
                    $states = [
                        'on' => ['value' => 1, 'text' => 'YES'],
                        'off' => ['value' => 0, 'text' => 'NO'],
                    ];
                    $grid->column('置顶和推荐')->switchGroup([
                        'is_recommended' => '推荐',
                        'is_top' => '置顶',
                            ], $states);
                    $grid->reply_count('回复数 ')->sortable();
                    $grid->view_count('浏览数')->sortable();
                    $grid->created_at('发表时间')->sortable();
                    $grid->deleted_at('状态')->display(function($deleted_at) {
                        return $deleted_at ? "<span class='label label-danger'>被删除</span>" : "<span class='label label-success'>正常</span>";
                    });
                    //$grid->updated_at('修改时间')->sortable();
                    // 不在页面显示 `新建` 按钮，因为我们不需要在后台新建话题
                    $grid->disableCreateButton();
                    $grid->filter(function($filter) {
                        // 去掉默认的id过滤器
                        //$filter->disableIdFilter();
                        // 在这里添加字段过滤器
                        $filter->like('title', '标题');
                        $filter->like('author.name', '作者');
                        $options = Category::all()->pluck('name', 'id')->toArray();
                        $options[' '] = '全部';
                        $filter->equal('category_id', '分类')->select($options);

                        $filter->equal('is_top', '置顶')->radio(['' => 'all', 1 => '是', 0 => '否',]);
                        $filter->equal('is_recommended', '加精')->radio(['' => 'all', 1 => '是', 0 => '否',]);
                    });
                    $grid->actions(function ($actions) {

                        $actions->append(new RestoreArticle($actions->getKey()));
                    });
                });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Article::class, function (Form $form) {
                    $form->display('id', 'ID');
                    $form->text('title', '标题')->rules('required|min:2');
                    $form->display('author.name', '作者');
                    $form->select('category_id', '分类')->options(Category::all()->pluck('name', 'id'))->rules('required|numeric');
                    $states = [
                        'on' => ['value' => 1, 'text' => 'YES'],
                        'off' => ['value' => 0, 'text' => 'NO'],
                    ];
                    $form->switch('is_recommended', '推荐')->states($states);
                    $form->switch('is_top', '置顶')->states($states);
                    $form->image('page_image', '文章头图')->rules('mimes:jpeg,bmp,png,gif|dimensions:min_width=750,min_height=250', ['dimensions' => '图片宽度不得小于750px,高度不得小于250px']);
                    $form->display('created_at', '发布时间');
                    $form->display('updated_at', '编辑时间');
                    $form->editor('content_html', '内容')->rules('required|min:10');
                    $form->saved(function (Form $form) {
                        Link::forgetRecommendedCached();
                    });
                });
    }

    public function destroy($id)
    {
        $article = Article::withTrashed()->findOrFail($id);
        $article->delete();
        if ($article->trashed()) {
            return response()->json([
                        'status' => true,
                        'message' => trans('admin.delete_succeeded'),
            ]);
        } else {
            return response()->json([
                        'status' => false,
                        'message' => trans('admin.delete_failed'),
            ]);
        }
    }

    public function restore($id)
    {
        $article = Article::withTrashed()->findOrFail($id);
        $article->restore();
        if (!$article->trashed()) {
            return response()->json([
                        'status' => true,
                        'message' => '恢复成功',
            ]);
        } else {
            return response()->json([
                        'status' => false,
                        'message' => '恢复失败',
            ]);
        }
    }

}
