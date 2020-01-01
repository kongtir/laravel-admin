<?php

namespace App\Admin\Controllers\Dy;

use Modules\Douying\Entities\DyCode;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Admin\Actions\Dy\GenerateCodePost;
use App\Admin\Actions\Dy\BatchDownCodePost;
class CodeController extends Controller
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
            ->header('激活码管理')
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
        $grid = new Grid(new DyCode);

        $grid->id('Id');
        $grid->yishou("已出售")->display(function ($yishou){
            if($yishou==1) return "<span style='color: red'><strong>已售</strong></span>";
            return "<span style='color: green'>-</span>";
        });
        $grid->used("已使用")->display(function ($used){
            if($used==1) return "<span style='color: red'><strong>是</strong></span>";
            return "<span style='color: green'><strong>否</strong></span>";
        });
        $grid->username("用户名");
        //$grid->userid('Userid');
        $grid->phone("账户");

        $grid->psd('密码');$grid->keys('激活码');
        $grid->selltime('销售时间')->display(function ($done){
            if($done==0) return "-";
            return date("Y-m-d H:i:s",$done);
        });;
        $grid->usetime('使用时间')->display(function ($done){
            if($done==0) return "-";
            return date("Y-m-d H:i:s",$done);
        });;
        $grid->marks('备注');
        $grid->gongzi('已获工资');
        $grid->status('状态')->display(function ($used){
            if($used==1) return "<span style='color: green'><strong>启用</strong></span>";
            return "<span style='color: red'><strong>禁用</strong></span>";
        });
        //$grid->created_at('Created at');
        //$grid->updated_at('Updated at');
        $grid->tools(function (Grid\Tools $tools) {
            $tools->append(new GenerateCodePost());
        });
        $grid->batchActions(function ($batch) {
            $batch->disableDelete();
            $batch->add(new BatchDownCodePost());
           // $batch->disableDelete();
        });

        //禁用创建按钮
        $grid->disableCreateButton();
        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            // $filter->LinkInfo()->like('url', 'url');
            $filter->scope("yishou",'已售')->where("yishou", 1);
            $filter->scope("noyishou",'未售')->where("yishou", 0);
            $filter->like('username', "账户");
            $filter->like('phone', "手机号");

            // $filter->BrowserInfo() ->like('browser', 'browser');
            // $filter->BrowserInfo()->like('os', 'os');

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
        $show = new Show(DyCode::findOrFail($id));

        $show->id('Id');
        $show->yishou('Yishou');
        $show->used('Used');
        $show->username('用户名');
        $show->userid('Userid');
        $show->phone('电话');

        $show->psd('Psd');$show->keys('Keys');
        $show->selltime('Selltime');
        $show->usetime('Usetime');
        $show->marks('Marks');
        $show->gongzi('Gongzi');
        $show->status('Status');
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
        $form = new Form(new DyCode);

        $form->switch('yishou', 'Yishou');
        $form->switch('used', 'Used');
        $form->text('username', '用户名');
        $form->number('userid', '用户ID');
        $form->mobile('phone', 'Phone');

        $form->text('psd', 'Psd');
        $form->text('keys', 'Keys');
        $form->number('selltime', 'Selltime');
        $form->number('usetime', 'Usetime');
        $form->text('marks', 'Marks');
        $form->decimal('gongzi', 'Gongzi')->default(0.00);
        $form->switch('status', 'Status');

        return $form;
    }
}
