<?php

namespace App\Admin\Controllers;

use App\Models\Tag;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class TagController extends Controller
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

                    $content->header('标签管理');
                    $content->description('标签列表');

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

                    $content->header('编辑标签');

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

                    $content->header('新增标签');

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
        return Admin::grid(Tag::class, function (Grid $grid) {

                    $grid->id('ID')->sortable();
                    $grid->name('名称')->display(function($name) {
                        return make_excerpt($name, 20);
                    });
                    $grid->meta_description('描述')->display(function($desc) {
                        return make_excerpt($desc, 20);
                    });
                    $grid->created_at();
                    $grid->updated_at();
                    $grid->filter(function($filter) {
                        $filter->like('name', '名称');
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
        return Admin::form(Tag::class, function (Form $form) {

                    $form->display('id', 'ID');
                    $form->text('name', '名称')->rules('required');
                    $form->text('meta_description', '描述');
                    $form->display('created_at', 'Created At');
                    $form->display('updated_at', 'Updated At');
                });
    }

}
