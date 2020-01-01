<?php

namespace App\Admin\Actions\Post;

use Encore\Admin\Actions\Action;
use Illuminate\Http\Request;

class ImportPost extends Action
{
    /*
     *   自定义工具样例
     *  http://www.laravel-admin.org/docs/zh/model-grid-custom-actions
  $grid->tools(function (Grid\Tools $tools) {
            $tools->append(new ImportPost());
        });
        use App\Admin\Actions\Post\ImportPost;
     */

    protected $selector = '.import-post';
    public $name = '导入数据';
    public function handle(Request $request)
    {
        // $request ...

        //return $this->response()->success('Success message...')->refresh();
        // 下面的代码获取到上传的文件，然后使用`maatwebsite/excel`等包来处理上传你的文件，保存到数据库
        $request->file('file');
        return $this->response()->success('导入完成！')->refresh();
    }
    public function form()
    {
        $this->file('file', '请选择文件');
    }
    public function html()
    {
        return <<<HTML
        <a class="btn btn-sm btn-default import-post">导入数据</a>
HTML;
    }
}