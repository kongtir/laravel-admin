<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;
///在model-grid的头部默认有批量删除和刷新两个操作工具，如果有更多的操作需求
/// ，model-grid提供了自定义工具的功能,下面的示例添加一个性别分类选择的按钮组工具。
class UserGender extends AbstractTool
{
    protected function script()
    {
        $url = Request::fullUrlWithQuery(['gender' => '_gender_']);

        return <<<EOT

$('input:radio.user-gender').change(function () {

    var url = "$url".replace('_gender_', $(this).val());

    $.pjax({container:'#pjax-container', url: url });

});

EOT;
    }

    public function render()
    {
        Admin::script($this->script());

        $options = [
            'all'   => 'All',
            'm'     => 'Male',
            'f'     => 'Female',
        ];

        return view('admin.tools.gender', compact('options'));
    }
}