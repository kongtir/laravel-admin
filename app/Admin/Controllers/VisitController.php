<?php

namespace App\Admin\Controllers;

use App\Models\VisitList;
use App\Models\IpInfo;
use App\Models\BrowserInfo;
use App\Models\LinkInfo;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Box;
use Illuminate\Support\Facades\DB;
class VisitController extends Controller
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

    public function VisitChart(Content $content){
        return $content
            ->header('Website access Chart')
            ->body(new Box('dingcheng666.top', view('admin.chartjs')));
    }

    public function GetVisitChartData(){

        // $sql ="select DATE_FORMAT(created_at,'%Y%m%d') days,(count(id)*6 + (id%10))  count from visit_lists where link_id in (SELECT id from link_infos where url like '%?%') group by days  ORDER BY id desc  LIMIT 100";
        //$url=htmlspecialchars($_GET["url"]);
        $url =   clearsql($_GET["url"]);
        //dump($url);
        $sql="select DATE_FORMAT(created_at,'%Y%m%d') days,count(id)  ct from visit_lists where link_id in (SELECT id from link_infos where url like '%$url%') group by days order by days desc LIMIT 7";

        //$results = DB::select('select * from users where id = :id', ['id' => 1]);
        //DB::insert('insert into users (id, name) values (?, ?)', [1, '学院君']);

         //DB::enableQueryLog();
        //执行语句

        $data = DB::select($sql);
       //dd(DB::getQueryLog());
       // $sql =DB::getlastsql();
        //$data["sql"]=DB::getQueryLog();
       // var_dump($data);exit();
        $x=array();
        $y=array();
        foreach($data as $val) {
           // var_dump($val->days);exit();
          //  dump($val["days"]);
         //   dump($val["ct"]);
            //array_push($x,$val->days);
           // array_push($y,$val->ct * 6 + ($val->days % 10));

            array_unshift($x,$val->days);
            array_unshift($y,$val->ct * 6 + ($val->days % 10));
        }




       // $res["data"] =$url;
        $res["title"]=$url;
        $res["subtext"]="the Website access data by last 7 days";
        //$res["legend"]=$url;
        $res["formatter"]="{value} Times";
        $res["xAxis"]=$x;//x轴数据
        $res["series"]=$y;//y轴数据
        $res["name"]=$url;//y轴数据



        return $res;


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
        $grid = new Grid(new VisitList);
        $grid->model()->orderBy('id', 'desc');
        //$grid->id('Id');
        $grid->speed('Speed');
        $grid->LinkInfo()->url()->display(function ($url){
            return "<a  href='/admin/Visit/VisitChart?url=$url'>$url</a>";
        });

        $grid->BrowserInfo()->browser();
        $grid->BrowserInfo()->language();
      //  $grid->BrowserInfo()->screen();
        $grid->BrowserInfo()->os();
        $grid->BrowserInfo()->wechat()->display(function ($wechat){
            if($wechat==0) return "--";
            return "wechat";
        })->style("align:center");

        $grid->IpInfo()->ip();
        $grid->IpInfo()->adress();
//        $grid->ip_id('IP-Info')->display(function($ip_id) {
//           $data87= IpInfo::find($ip_id);
//           return $data87->ip.",".$data87->adress;
//
//        });
//        $grid->link_id('Link-info')->display(function($link_id) {
//            return LinkInfo::find($link_id)->url;
//
//        });
        //$data_bro=null;
//        $grid->browser_id('Browser')->display(function($browser_id) {
//            $data_bro= BrowserInfo::find($browser_id);
//            return $data_bro->browser;
//        });
       // $grid->column('ip_id',"456");
        //$grid->visitortime('Visitortime');
        $grid->created_at('Created at');
        //$grid->updated_at('Updated at');
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
           // $actions->disableView();
        });
        //目前默认实现了批量删除操作的功能，如果要关掉批量删除操作：
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });
        //禁用创建按钮
        $grid->disableCreateButton();
        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
           // $filter->LinkInfo()->like('url', 'url');
            $filter->between('created_at', "Created at")->datetime();
            $filter->like("speed","speed");
            $filter->where(function ($query){
                $query->whereHas('LinkInfo', function ($query) {
                    $query->where('url', 'like', "%{$this->input}%");
                });
            },"URL");

            $filter->where(function ($query){
                $query->whereHas('BrowserInfo', function ($query) {
                    $query->where('browser', 'like', "%{$this->input}%")->orWhere('os', 'like', "%{$this->input}%");
                });
            },"browser or OS");
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
        $show = new Show(VisitList::findOrFail($id));

        $show->id('Id');
        $show->speed('Speed');
        $show->ip_id('Ip id');
        $show->link_id('Link id');
        $show->browser_id('Browser id');
        $show->visitortime('Visitortime');
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
        $form = new Form(new VisitList);

        $form->text('speed', 'Speed');
        $form->number('ip_id', 'Ip id');
        $form->number('link_id', 'Link id');
        $form->number('browser_id', 'Browser id');
        $form->number('visitortime', 'Visitortime');

        return $form;
    }
}
