<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Article extends Model{
    protected $guarded = [];
    
    //获取文章所属分类
    public function article_classify(){
        return $this->belongsTo('App\Models\Admin\Article_classify','classid');
    }
}
