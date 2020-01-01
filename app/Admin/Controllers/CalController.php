<?php

namespace App\Admin\Controllers;

use Modules\Tools\Entities\TCalculator;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CalController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *php artisan admin:make CalController --model=Modules\\Tools\\Entities\\TCalculator
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
        $grid = new Grid(new TCalculator);

        $grid->id('Id');
        $grid->price('Price');
        $grid->name('Name');
        $grid->img('Img');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');
        $grid->url('Url');

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
        $show = new Show(TCalculator::findOrFail($id));

        $show->id('Id');
        $show->price('Price');
        $show->name('Name');
        $show->img('Img');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        $show->url('Url');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new TCalculator);

        $form->number('price', 'Price');
        $form->text('name', 'Name');
        $form->image('img', 'Img');
        $form->url('url', 'Url');

        return $form;
    }
}
