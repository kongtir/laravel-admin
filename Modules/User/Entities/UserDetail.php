<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

//php artisan module:make-model UserDetail User -m
//同时创建模型和迁移文件
/**
 * 模块：迁移
迁移给定模块，或者没有模块参数，迁移所有模块。
php artisan module:migrate Blog
 *
模块：迁移回滚
回滚给定模块，或者不带参数，回滚所有模块。
php artisan module:migrate-rollback Blog
 *
模块：迁移刷新
刷新给定模块的迁移，或者没有指定模块刷新所有模块迁移。
php artisan module:migrate-refresh Blog
 */


class UserDetail extends Model
{
    protected $fillable = [];
}
