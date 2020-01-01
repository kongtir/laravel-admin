<?php

namespace Modules\Tools\Entities;

use Illuminate\Database\Eloquent\Model;

//php artisan admin:make MsgController --model=Modules\\Tools\\Entities\\Message
//php artisan module:make-model Message Tools -m
//php artisan module:make-controller MsgController Tools
class Message extends Model
{
    protected $fillable = [];
}
