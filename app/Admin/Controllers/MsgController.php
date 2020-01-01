<?php

namespace App\Admin\Controllers;

use Modules\Tools\Entities\Message;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class MsgController extends Controller
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
            ->header('Index')
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
        $grid = new Grid(new Message);

        $grid->id('Id');
        $grid->send('Send');
        $grid->sendid('Sendid');
        $grid->att('Att');
        $grid->attid('Attid');
        $grid->text('Text');
        $grid->img('Img');
        $grid->read('Read');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

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
        $show = new Show(Message::findOrFail($id));

        $show->id('Id');
        $show->send('Send');
        $show->sendid('Sendid');
        $show->att('Att');
        $show->attid('Attid');
        $show->text('Text');
        $show->img('Img');
        $show->read('Read');
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
        $form = new Form(new Message);

        $form->text('send', 'Send');
        $form->number('sendid', 'Sendid');
        $form->text('att', 'Att');
        $form->number('attid', 'Attid');
        $form->text('text', 'Text');
        $form->image('img', 'Img');
        $form->number('read', 'Read');

        return $form;
    }
}
