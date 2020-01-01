<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    /**
     * 属性类型
     *
     * @var array
     * 比如说 articles 表中有个 tag_id 字段是记录这篇文章属于哪个标签的；
    因为一篇文章可能有多个标签；
    那么 tag_id 字段是可以存多个 id 的；
    又因为数据库没法直接存个php的数组；
    所以我们可以把多个 id 通过json_encode函数转成json存到数据库；
    获取数据的时候；再通过 json_decode转成php数组；
    这种场景可以直接使用属性类型转换；
    在模型文件中定义 casts ；
     */
    protected $casts = [
        'tag_id' => 'array',
    ];

    /**
     * 我们可以自定义访问器和存储器；
    下面手动定义一个访问器和存储器实现属性类型的功能；
    命名的规则就是get/set字段名Attribute；
     *
     * 存入数据库的时候；把数组转成 json
     * @param  string  $value
     * @return void
     */
    public function setTagIdAttribute($value)
    {
        $this->attributes['tag_id'] = json_encode($value);
    }

    /**
     * 获取数据时把json转成php数组
     * @param  string  $value
     * @return string
     */
    public function getTagIdAttribute($value)
    {
        return json_decode($value, true);
    }
}
