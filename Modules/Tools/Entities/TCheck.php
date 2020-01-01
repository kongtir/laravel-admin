<?php

namespace Modules\Tools\Entities;

use Illuminate\Database\Eloquent\Model;

//php artisan module:make-model TCheck Tools -m
//同时创建模型和迁移文件
//Created : /mnt/win/Items/laravel-admin/Modules/Tools/Entities/TCheck.php
//Created : /mnt/win/Items/laravel-admin/Modules/Tools/Database/Migrations/2019_03_19_072241_create_t_checks_table.php
class TCheck extends Model
{
    protected $fillable = [];
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = true;
    /**
     * 模型日期列的存储格式
     *
     * @var string
     */
   // protected $dateFormat = 'U';
}
