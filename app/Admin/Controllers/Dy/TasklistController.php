<?php

namespace App\Admin\Controllers\Dy;

use Modules\Douying\Entities\DyTasklist;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TasklistController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '任务审核';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new DyTasklist);

        $grid->column('id', __('Id'));
        $grid->column('username', __('Username'));
        $grid->column('userid', __('Userid'));
        $grid->column('taskid', __('Taskid'));
        $grid->column('applytime', __('Applytime'));
        $grid->column('subtime', __('Subtime'));
        $grid->column('closetime', __('Closetime'));
        $grid->column('status', __('Status'));
        $grid->column('mark', __('Mark'));
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
        $show = new Show(DyTasklist::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('username', __('Username'));
        $show->field('userid', __('Userid'));
        $show->field('taskid', __('Taskid'));
        $show->field('applytime', __('Applytime'));
        $show->field('subtime', __('Subtime'));
        $show->field('closetime', __('Closetime'));
        $show->field('status', __('Status'));
        $show->field('mark', __('Mark'));
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
        $form = new Form(new DyTasklist);

        $form->text('username', __('Username'));
        $form->number('userid', __('Userid'));
        $form->number('taskid', __('Taskid'));
        $form->number('applytime', __('Applytime'));
        $form->number('subtime', __('Subtime'));
        $form->number('closetime', __('Closetime'));
        $form->text('status', __('Status'))->default('等待提交');
        $form->text('mark', __('Mark'));

        return $form;
    }
}
