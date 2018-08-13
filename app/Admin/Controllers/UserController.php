<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class UserController extends Controller
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

                    $content->header('用户列表');
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

                    $content->header('编辑用户');
                    $content->body($this->form()->edit($id));
                });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        // 根据回调函数，在页面上用表格的形式展示用户记录
        return Admin::grid(User::class, function (Grid $grid) {

                    // 创建一个列名为 ID 的列，内容是用户的 id 字段，并且可以在前端页面点击排序
                    $grid->id('ID')->sortable();
                    // 创建一个列名为 用户名 的列，内容是用户的 name 字段。下面的 email() 和 created_at() 同理
                    $grid->name('用户名');
                    $grid->avatar('头像')->display(function($avatar) {
                        return "<img src='$avatar' style='width:32px;height:32px;'>";
                    });
                    $grid->email('邮箱');
                    $grid->phone('手机号码');
                    $grid->is_activated('已验证邮箱')->display(function ($value) {
                        return $value ? '是' : '否';
                    });
                    $grid->created_at('注册时间');
                    $states = [
                        'on' => ['value' => 1, 'text' => 'yes', 'color' => 'danger'],
                        'off' => ['value' => 0, 'text' => 'no', 'color' => 'primary'],
                    ];
                    $grid->is_blocked('是否封禁')->switch($states);

                    // 不在页面显示 `新建` 按钮，因为我们不需要在后台新建用户
                    $grid->disableCreateButton();
                    $grid->actions(function ($actions) {

                        // 不在每一行后面展示删除按钮
                        $actions->disableDelete();

                        // 不在每一行后面展示编辑按钮
//                        $actions->disableEdit();
                    });
                    $grid->filter(function($filter) {
                        // 去掉默认的id过滤器
                        //$filter->disableIdFilter();
                        // 在这里添加字段过滤器
                        $filter->like('name', '用户名');
                        $filter->equal('is_activated', '已验证邮箱')->radio(['' => 'all', 1 => '是', 0 => '否',]);
                        $filter->equal('is_blocked', '已被封禁')->radio(['' => 'all', '1' => '是', '0' => '否']);
                    });
                    $grid->tools(function ($tools) {

                        // 禁用批量删除按钮
                        $tools->batch(function ($batch) {
                            $batch->disableDelete();
                        });
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
        return Admin::form(User::class, function (Form $form) {

                    $form->display('id', 'ID');
                    $form->display('name', '用户名');
                    $form->display('email', '邮箱');
                    $states = [
                        'on' => ['value' => 1, 'text' => 'yes', 'color' => 'danger'],
                        'off' => ['value' => 0, 'text' => 'no', 'color' => 'primary'],
                    ];
                    $form->switch('is_blocked', '是否封禁')->states($states);
                    $form->display('created_at', '注册时间');
                    $form->display('updated_at', '修改时间');
                });
    }

}
