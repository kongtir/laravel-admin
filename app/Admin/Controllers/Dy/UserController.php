<?php

namespace App\Admin\Controllers\Dy;

use Modules\Douying\Entities\DyUser;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '会员管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new DyUser);

        $grid->column('id', __('Id'));
        $grid->column('username', __('Username'));
        $grid->column('password', __('Password'));
        $grid->column('nickname', __('Nickname'));
        $grid->column('truename', __('Truename'));
        $grid->column('phone', __('Phone'));
        $grid->column('edittime', __('Edittime'));
        $grid->column('logintime', __('Logintime'));
        $grid->column('photo', __('Photo'));
        $grid->column('status', __('Status'));
        $grid->column('yaoqingren', __('Yaoqingren'));
        $grid->column('alipay', __('Alipay'));
        $grid->column('wechat', __('Wechat'));
        $grid->column('dongjie', __('Dongjie'));
        $grid->column('leijitixian', __('Leijitixian'));
        $grid->column('yue', __('Yue'));
        $grid->column('gongxian', __('Gongxian'));
        $grid->column('icard', __('Icard'));
        $grid->column('adress', __('Adress'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('leiji', __('Leiji'));
        $grid->column('appkey', __('Appkey'));

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
        $show = new Show(DyUser::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('username', __('Username'));
        $show->field('password', __('Password'));
        $show->field('nickname', __('Nickname'));
        $show->field('truename', __('Truename'));
        $show->field('phone', __('Phone'));
        $show->field('edittime', __('Edittime'));
        $show->field('logintime', __('Logintime'));
        $show->field('photo', __('Photo'));
        $show->field('status', __('Status'));
        $show->field('yaoqingren', __('Yaoqingren'));
        $show->field('alipay', __('Alipay'));
        $show->field('wechat', __('Wechat'));
        $show->field('dongjie', __('Dongjie'));
        $show->field('leijitixian', __('Leijitixian'));
        $show->field('yue', __('Yue'));
        $show->field('gongxian', __('Gongxian'));
        $show->field('icard', __('Icard'));
        $show->field('adress', __('Adress'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('leiji', __('Leiji'));
        $show->field('appkey', __('Appkey'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new DyUser);

        $form->text('username', __('Username'));
        $form->password('password', __('Password'));
        $form->text('nickname', __('Nickname'));
        $form->text('truename', __('Truename'));
        $form->mobile('phone', __('Phone'));
        $form->datetime('edittime', __('Edittime'))->default(date('Y-m-d H:i:s'));
        $form->datetime('logintime', __('Logintime'))->default(date('Y-m-d H:i:s'));
        $form->text('photo', __('Photo'));
        $form->switch('status', __('Status'))->default(1);
        $form->text('yaoqingren', __('Yaoqingren'));
        $form->text('alipay', __('Alipay'));
        $form->text('wechat', __('Wechat'));
        $form->decimal('dongjie', __('Dongjie'))->default(0.00);
        $form->decimal('leijitixian', __('Leijitixian'))->default(0.00);
        $form->decimal('yue', __('Yue'))->default(0.00);
        $form->decimal('gongxian', __('Gongxian'))->default(0.00);
        $form->text('icard', __('Icard'));
        $form->text('adress', __('Adress'));
        $form->decimal('leiji', __('Leiji'))->default(0.00);
        $form->text('appkey', __('Appkey'));

        return $form;
    }
}
