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
    public function article_list(Request $request){
        $get = $request->only(['classid','start_time','end_time','name']);
        $model = Article::query();
        if(isset($request->name)){
            $model->where('title','like','%'.$request->name.'%');
        }
        if($request->classid){
            $model->where('classid',$request->classid);
        }
        if($request->start_time){
            $model->where('updated_at','>=',$request->start_time);
        }
        if($request->end_time){
            //搜索条件为年-月-日，数据库为年-月-日 时:分:秒 .所有end_time需要加一天为上限
            $end_time = date('Y-m-d', strtotime ("+1 day", strtotime($request->end_time)));
            $model->where('updated_at','<=',$end_time);
        }
        $list = $model->with('article_classify')
            ->orderBy('stick','asc')
            ->orderBy('updated_at','desc')
            ->paginate(10);
        $count = $model->count();
        $classify = Article_classify::all();
        $request->session()->flash('name',$request->name);
        $request->session()->flash('classid',$request->classid);
        $request->session()->flash('start_time',$request->start_time);
        $request->session()->flash('end_time',$request->end_time);
        
        return view('admin.article.article_list',compact('list','count','classify'));
    }
    //测试
    public function ceshi(){
        //$article = Article_classify::find(1)->article()->select(['id','title'])->get();
//         $article = Article::with('article_classify')->get();
//         foreach($article as $v){
//             echo $v->article_classify->name;
//         }
//         dd($article);
        
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
            if(empty($data['cover'])){
                return response()->json(['code'=>'0','msg'=>'请上传封面']);
            }
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
        $article = Article::findOrFail($id);
        $classify = Article_classify::all();
        return view('admin.article.article_update',['article'=>$article,'classify'=>$classify]);
    }
    //文章修改提交
    public function article_edit(ArticleRequest $request,$id){
        if($request->isMethod('PUT')){
            $article = Article::findOrFail($id);
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
    //文章删除
    public function article_delete(Request $request){
        $id = $request->id;
        $id = is_array($id) ? $id : [$id];
        $article = Article::whereIn('id',$id)->select('cover')->get();
        $re = Article::destroy($id);
        if($re){
            foreach($article as $v){
                unlink('storage/'.$v['cover']); // 删除旧目录下的图片
            }
            $code = '200';
            $msg = '删除成功';
        }else{
            $code = '0';
            $msg = '删除失败';
        }
        return response()->json(['code'=>$code,'msg'=>$msg]);
    }
    //发布/下架文章
    public function article_state(Request $request){
        $id = $request->id;
        $article = Article::find($id);
        $state = $article->state == 1 ? 0 : 1;
        $article->state = $state;
        $re = $article->save();
        if($re){
            $code = 200;
            $msg = $state == 0 ? '已下架' : '发布成功';
        }else{
            $code = 0;
            $msg = $state == 0 ? '下架失败' : '发布失败';
        }
        return response()->json(['code'=>$code,'msg'=>$msg]);
    }
    public function article_class(){
        return view('admin.article.article_class');
    }
    public function article_class_edit(){
        return view('admin.article.article_class_edit');
    }
}
