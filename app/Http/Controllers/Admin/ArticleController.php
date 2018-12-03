<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Article;
use App\Http\Requests\ArticleRequest;
use App\Models\Admin\Article_classify;
class ArticleController extends Controller{
    //文章列表
    public function article_list(){
        $list = Article::join('article_classifies as c','articles.classid','c.id')
            ->orderBy('stick','asc')
            ->orderBy('updated_at','desc')
            ->select('articles.*','c.name')
            ->paginate(10);
        return view('admin.article.article_list',['list'=>$list]);
    }
    public function article_add(){
        $classify = Article_classify::all();
        return view('admin.article.article_add',['classify'=>$classify]);
    }
    //提交文章表单
    public function article_create(ArticleRequest $request){
        if($request->isMethod('ajax')){
            dd($request->all());
        }
    }
    public function article_class(){
        return view('admin.article.article_class');
    }
    public function article_class_edit(){
        return view('admin.article.article_class_edit');
    }
}
