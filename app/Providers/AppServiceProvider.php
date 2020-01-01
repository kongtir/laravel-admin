<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //laravel 可以使用 View::composer ;
        // 分配前台通用的 category 数据
       /**  view()->composer('home/*', function ($view) {
            // 获取配置项
            $category = Category::all();
            $assign = [
                'category' => $category
            ];
            $view->with($assign);
        }); */
        //第一个参数的 home/* ；指的是 resources/views/home 目录

      Schema::defaultStringLength(191);
    }
}
