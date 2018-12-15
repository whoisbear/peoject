<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Article_classify extends Model{
    public $timestamps = false;
    
    /**
     * 获取分类下的所有文章
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function article(){
        return $this->hasMany('App\Models\Admin\Article','classid');
    }
}
