<?php

namespace App\Admin\Controllers\Dy;

use Modules\Douying\Entities\DyTask;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class TaskController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('任务发布')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new DyTask);

        $grid->id('Id');
        $grid->nickname('昵称');
        $grid->username('用户名');
        $grid->userid('ID');
        $grid->types('类别');
        $grid->maxreward('最大赏金');
        $grid->total('总量');
        $grid->balance('剩余');
        $grid->top('是否置顶') ->display(function($top) {
            // return User::find($userId)->name;
            return $top==1?"<span style='color: green'>是</span>":"<span style='color: red'>否</span>";
        });
        $grid->mark('任务描述');
        //$grid->url('Url');
        $grid->created_at('Created at');
        //$grid->updated_at('Updated at');

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
        $show = new Show(DyTask::findOrFail($id));

        $show->id('Id');
        $show->nickname('Nickname');
        $show->username('Username');
        $show->userid('Userid');
        $show->types('Types');
        $show->maxreward('Maxreward');
        $show->total('Total');
        $show->balance('Balance');
        $show->top('Top');
        $show->mark('Mark');
        $show->url('Url');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new DyTask);

        $form->text('nickname', '昵称');
        $form->text('username', '用户名')->default("");
        $form->number('userid', '用户ID:不要改')->default(0);
        $form->text('types', 'Types')->default('抖音点赞');
        $form->decimal('maxreward', '最大赏金')->default(0.00);
        $form->number('total', '总量');
        $form->number('balance', '剩余');
        $form->switch('top', '是否置顶:1置顶,0不置顶')->default(1);
        $form->text('mark', '任务描述:可不填');
        $form->url('url', '任务链接');

        return $form;
    }
}
