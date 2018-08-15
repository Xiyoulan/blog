<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Layout\Column;
use Encore\Admin\Tree;
use Encore\Admin\Widgets\Box;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class CategoryController extends Controller
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

                    $content->header('分类管理');
                    $content->description('分类列表');
                    $content->row(function (Row $row) {
                        $row->column(6, Category::tree(function(Tree $tree) {
                                   $tree->disableCreate();
                                }));
                        $row->column(6, function (Column $column) {
                            $form = new \Encore\Admin\Widgets\Form();
                            $form->action(admin_base_path('categories'));
                            $form->select('parent_id', '父级')->options(Category::selectOptions());
                            $form->text('name', '名称')->rules('required');
                            $form->textarea('description', '描述');
                            $column->append((new Box('新增', $form))->style('success'));
                        });
                    });

                    //$content->body(Category::tree());
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

                    $content->header('编辑分类');

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

                    $content->header('新增分类');

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
        return Admin::grid(Category::class, function (Grid $grid) {

                    $grid->id('ID')->sortable();

                    $grid->created_at();
                    $grid->updated_at();
                });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Category::class, function (Form $form) {

                    $form->display('id', 'ID');
                    $form->select('parent_id', '父级')->options(Category::selectOptions());
                    $form->text('name', '名称')->rules('required');
                    $form->textarea('description', '描述');
                    $form->display('created_at', 'Created At');
                    $form->display('updated_at', 'Updated At');
                });
    }

}
