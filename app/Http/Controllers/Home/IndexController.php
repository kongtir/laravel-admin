<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
class IndexController extends Controller
{
    //php artisan  make:controller Home/IndexController
    ///home/index/index/1?name=白俊遥
    public function index($id, Request $request)
    {
        echo $id; // 输出 1
        echo $request->input('name'); // 输出 白俊遥
    }

    public function index2()
    {
        $assign = [
            'title' => '白俊遥文章的标题',
            'content' => '白俊遥文章的内容'
        ];
        return view('home.index.index', $assign);
        //等价于 return view('home/index/index', $assign);
     //控制器中的方法返回页面或者redirect都必须要 return ；
    }


    /**
     * 控制器中的index方法
     */
    public function index3(){
        D('Articles')->getArticleList();
    }

    /**
     * laravel 控制器的方法是可以直接传模型的；
    这涉及到一个概念叫 依赖注入;
    不懂是什么东西的先搜搜补下基础；
    用的时候就是这个样子；
    需要先
    然后如下；
     */
    public function index4(Article $articleModel){
        dump(1);

        $articleModel->getArticleList();
    }


// compact 的作用
    public function index5()
    {
        $article = Article::all();
        $category = Category::all();
        $tag = Tag::all();
        $assign = [
            'article' => $article,
            'category' => $category,
            'tag' => $tag
        ];
        return view('home.index.index', $assign);
    }
    // compact 的作用
    public function index51()
    {
        $article = Article::all();
        $category = Category::all();
        $tag = Tag::all();
        $assign = compact('article', 'category', 'tag');
        return view('home.index.index', $assign);
    }


}
