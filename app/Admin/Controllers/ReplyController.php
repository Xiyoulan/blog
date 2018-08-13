<?php

namespace App\Admin\Controllers;

use App\Models\Reply;
use App\Admin\Extensions\RestoreReply;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ReplyController extends Controller
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

                    $content->header('回复管理');
                    $content->description('回复列表');

                    $content->body($this->grid());
                });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Reply::class, function (Grid $grid) {
                    $grid->model()->withTrashed();
                    $grid->id('ID')->sortable();
                    $grid->replyFrom()->name('回复者');
                    $grid->article()->title('话题')->display(function($title) {
                        //会造成n+1问题 暂时没办法解决
                        $url = $this->link();
                        return "<a href='$url'>" . make_excerpt($title, 30) . "<a>";
                    });
                    $grid->content('内容')->display(function($content) {
                        return make_excerpt($content, 30);
                    });
                    $grid->parent_id('节点')->display(function($parent_id) {
                        return $parent_id ? "<span class='label label-info'>子</span>" : "<span class='label label-primary'>父</span>";
                    });
                    $grid->layer('楼层')->display(function($layer) {
                        return '#' . $layer;
                    });
                    $grid->deleted_at('状态')->display(function($deleted_at) {
                        return $deleted_at ? "<span class='label label-danger'>被删除</span>" : "<span class='label label-success'>正常</span>";
                    });
                    $grid->created_at('回复时间')->sortable();;
                    $grid->disableCreateButton();
                    $grid->actions(function ($actions) {
                        $actions->disableEdit();
                        $actions->append(new RestoreReply($actions->getKey()));
                    });
                    $grid->filter(function($filter) {
                        // 去掉默认的id过滤器
                        //$filter->disableIdFilter();
                        // 在这里添加字段过滤器
                        $filter->like('article.title', '标题');
                        $filter->like('replyFrom.name', '回复者');
                        $filter->between('created_at', '回复时间')->datetime();
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
        return Admin::form(Reply::class, function (Form $form) {

                    $form->display('id', 'ID');

                    $form->display('created_at', 'Created At');
                    $form->display('updated_at', 'Updated At');
                });
    }

    public function destroy($id)
    {
        $reply = Reply::withTrashed()->findOrFail($id);
        $reply->delete();
        if ($reply->trashed()) {
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
        $reply = Reply::withTrashed()->findOrFail($id);
        $reply->restore();
        if (!$reply->trashed()) {
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
