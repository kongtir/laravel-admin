<?php

namespace Modules\Tools\Providers;

use Illuminate\Support\ServiceProvider;
//php artisan module:make-provider ImgServiceProvider Tools
class ImgServiceProvider extends ServiceProvider
{
    /**
     * 图形验证码
     * @param $appkey
     * @param $code
     * @param $num 图形验证码 字符个数
     * @param int $size
     * @param int $width
     * @param int $height
     */
    public function GetImgCode($code,$num=4, $size = 15, $width = 0, $height = 0)
    {
       //本方法无法正常使用已丢弃
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
