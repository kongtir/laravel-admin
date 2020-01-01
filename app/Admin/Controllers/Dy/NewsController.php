<?php

namespace App\Admin\Controllers\Dy;

use Modules\Douying\Entities\DyNews;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class NewsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '公告管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new DyNews);

        $grid->column('id', __('Id'));
        $grid->column('title', __('标题'));
        $grid->column('author', __('作者'));
        $grid->column('types', __('分类'));
        $grid->column('introduce', __('简介'));
        $grid->column('centent', __('内容'));
        $grid->column('hits', __('点击次数'));
        $grid->column('status', __('是否可见'));
        $grid->column('addtime', __('添加时间'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(DyNews::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('标题'));
        $show->field('author', __('作者'));
        $show->field('types', __('分类'));
        $show->field('introduce', __('简介'));
        $show->field('centent', __('内容'));
        $show->field('hits', __('点击次数'));
        $show->field('status', __('是否可见'));
        $show->field('addtime', __('添加时间'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new DyNews);

        $form->text('title', __('标题'));
        $form->text('author', __('作者'))->default('官方团队');
        $form->text('types', __('分类'))->default('公告');
        $form->text('introduce', __('简介'));
        $form->textarea('centent', __('内容'));
        $form->number('hits', __('点击次数'));
        $form->switch('status', __('是否可见'))->default(1);
        $form->number('addtime', __('添加时间'));

        return $form;
    }
}
