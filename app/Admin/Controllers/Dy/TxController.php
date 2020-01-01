<?php

namespace App\Admin\Controllers\Dy;

use Encore\Admin\Actions\Action;
use Modules\Douying\Entities\DyTx;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Admin\Actions\Dy\TXfail;
use App\Admin\Actions\Dy\TXOK;
use  App\Admin\Extensions\CheckRow;
class TxController extends Controller
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
            ->header('检查')
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
        $grid = new Grid(new DyTx);

        $grid->id('Id');
        $grid->card('Card');
        $grid->txtype('Txtype');
        $grid->username('Username');
        $grid->userid('Userid');
        $grid->truename('Truename');
        $grid->status('Status')->display(function ($done){
            switch ($done){
                case 0 :return "<span style='background-color: yellowgreen'>待审核</span>";
                case 1 :return "<span style='color: green'>审核通过</span>";
                case 2 :return "<span style='color: red'>已驳回</span>";
                default: return "<span style='background-color: red'>未知?</span>";
            }
        });;
        $grid->payed('Payed')->display(function ($done){
            return $done==0?"未支付":"已支付";
        });
        $grid->amount('Amount');
        $grid->tax('Tax');
        $grid->done('处理时间')->display(function ($done){
            return date("Y-m-d H:i:s",$done);
        });
        $grid->apply('申请时间')->display(function ($apply){
            return date("Y-m-d H:i:s",$apply);
        });
        //$grid->created_at('Created at');
        //$grid->updated_at('Updated at');
        //$grid->disableActions();
        $grid->actions(function ($actions) {
            $actions->add(new TXfail());
            $actions->add(new TXOK());

        });
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
        $show = new Show(DyTx::findOrFail($id));

        $show->id('Id');
        $show->card('Card');
        $show->txtype('Txtype');
        $show->username('Username');
        $show->userid('Userid');
        $show->truename('Truename');
        $show->status('Status');
        $show->payed('Payed');
        $show->amount('Amount');
        $show->tax('Tax');
        $show->done('Done');
        $show->apply('Apply');
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
        $form = new Form(new DyTx);

        $form->text('card', 'Card');
        $form->text('txtype', 'Txtype');
        $form->text('username', 'Username');
        $form->number('userid', 'Userid');
        $form->text('truename', 'Truename');
        $form->switch('status', 'Status');
        $form->switch('payed', 'Payed');
        $form->number('amount', 'Amount');
        $form->number('tax', 'Tax')->default(1);
        $form->number('done', 'Done');
        $form->number('apply', 'Apply');

        return $form;
    }
}
