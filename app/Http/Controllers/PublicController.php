<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicController extends Controller
{
    //图片上传处理
    public function uploadImg(Request $request,$file_name = 'cover')
    {

        //上传文件最大大小,单位M
        $maxSize = 10;
        //支持的上传图片类型
        $allowed_extensions = ["png", "jpg", "gif"];
        //返回信息json
        $file = $request->file($file_name);

        //检查文件是否上传完成
        if ($file->isValid()){
            //检测图片类型
            $ext = $file->getClientOriginalExtension();
            if (!in_array(strtolower($ext),$allowed_extensions)){
                $data['msg'] = "请上传".implode(",",$allowed_extensions)."格式的图片";
                $data['code'] = 0;
                return response()->json($data);
            }
            //检测图片大小
            if ($file->getClientSize() > $maxSize*1024*1024){
                $data['msg'] = "图片大小限制".$maxSize."M";
                $data['code'] = 0;
                return response()->json($data);
            }
        }else{
            $data['msg'] = $file->getErrorMessage();
            $data['code'] = 0;
            return response()->json($data);
        }
        //获取文件的绝对路径
        $path = $file->getRealPath();
        $newFile = date('Y-m-d')."_".time()."_".uniqid().".".$file->getClientOriginalExtension();
        //存储文件。disk里面的public。总的来说，就是调用disk模块里的public配置
        Storage::disk('img')->put($newFile, file_get_contents($path));
        $data['code'] = 200;
        $data['msg'] = '上传成功';
        $data['src'] = 'uploadImg/'.$newFile;
        
        return $data;
    }



}