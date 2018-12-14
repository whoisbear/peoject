<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Article;
use App\Http\Requests\ArticleRequest;
use App\Http\Controllers\PublicController;
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
    //文章表单view
    public function article_add(Request $request){
        $classify = Article_classify::all();
        return view('admin.article.article_add',['classify'=>$classify]);
    }
    //文章表单提交
    public function article_create(ArticleRequest $request){
        if($request->isMethod('POST')){
            $article = new Article();
            $data = $request->all();
            $public = new PublicController();
            $file = $public->uploadImg($request,'cover');
            if($file['code'] == 200){
                $data['cover'] = $file['src'];
            }else{
                return response()->json(['code'=>$file['code'],'msg'=>$file['msg']]);
            }
            $re = $article->create($data);
            if($re){
                $code = '200';
                $msg = '添加成功';
            }else{
                $code = '0';
                $msg = '添加失败';
            }
            return response()->json(['code'=>$code,'msg'=>$msg]);
        }
    }
    //文章修改
    public function article_update($id){
        $article = Article::find($id);
        $classify = Article_classify::all();
        return view('admin.article.article_update',['article'=>$article,'classify'=>$classify]);
    }
    //文章修改提交
    public function article_edit(ArticleRequest $request,$id){
        if($request->isMethod('PUT')){
            $article = Article::find($id);
            $data = $request->all();
            if(!empty($data['cover'])){
                $public = new PublicController();
                $file = $public->uploadImg($request,'cover');
                if($file['code'] == 200){
                    $data['cover'] = $file['src'];
                    unlink('storage/'.$article->cover); // 删除旧目录下的图片
                }else{
                    return response()->json(['code'=>$file['code'],'msg'=>$file['msg']]);
                }
            }else{
                unset($data['cover']);
            }
            $re = $article->update($data);
            if($re){
                $code = '200';
                $msg = '编辑成功';
            }else{
                $code = '0';
                $msg = '编辑失败';
            }
            return response()->json(['code'=>$code,'msg'=>$msg]);
        }
    }
    public function article_class(){
        return view('admin.article.article_class');
    }
    public function article_class_edit(){
        return view('admin.article.article_class_edit');
    }
}
