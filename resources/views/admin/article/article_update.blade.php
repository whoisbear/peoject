@extends('admin._meta')
@section('common')
<article class="page-container">
	<form class="form form-horizontal" id="form-article-add" enctype="multipart/form-data">
	{{ csrf_field() }}
	{{ method_field('put') }}
	<input type="hidden" name="id" value="{{$article->id}}">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>文章标题：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$article->title}}" placeholder="" id="title" name="title">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>分类栏目：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="classid" class="select">
			    @foreach($classify as $v)
					<option value="{{$v->id}}" @if($v->id == $article->classid) selected @endif>{{$v->name}}</option>
				@endforeach	
				</select>
				</span> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">排序值：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$article->px or 255}}" placeholder="" id="articlesort" name="px">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">文章摘要：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<textarea name="remark" id="remark" cols="" rows="" class="textarea"  placeholder="说点什么...">{{$article->remark}}</textarea>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">浏览次数：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$article->browse or 0}}" placeholder="" id="browse" name="browse">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">文章作者：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$article->auther or 'admin'}}" placeholder="" id="auther" name="auther">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">文章来源：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$article->from or '官方'}}" placeholder="" id="sources" name="from">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">允许评论：</label>
			<div class="formControls col-xs-8 col-sm-9 skin-minimal">
				<div class="check-box">
					<input type="checkbox" name="can_comment" value="1" @if($article->can_comment == 1) checked @endif >
					<label for="checkbox-pinglun">&nbsp;</label>
				</div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">置顶：</label>
			<div class="formControls col-xs-8 col-sm-9 skin-minimal">
				<div class="check-box">
					<input type="checkbox" name="stick" value="1" @if($article->stick == 1) checked @endif >
					<label for="checkbox-pinglun">&nbsp;</label>
				</div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">文章状态：</label>
			<div class="formControls col-xs-8 col-sm-9 skin-minimal">
				<div class="radio-box">
					<input name="state" type="radio"  value="1" @if($article->state == 1) checked @endif >
					<label>已发布</label>
				</div>
				<div class="radio-box">
					<input name="state" type="radio"  value="0" @if($article->state == 0) checked @endif >
					<label>下架</label>
				</div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">缩略图：</label>
			<div class="formControls col-xs-8 col-sm-9">
				 <div class="layui-upload">
                    <button type="button" class="layui-btn" id="img_button"><i class="layui-icon">&#xe67c;</i>图片上传</button>
                    <div class="layui-upload-list" >
                        <ul id="layui-upload-box" class="layui-clear">
                            <li><img id="img0" src="{{URL::asset('storage/'.$article->cover)}}" /><p></p></li>
                        </ul>
                        <input type="file" style='display:none' name="cover" id="file0" value="{{$article->cover}}">
                    </div>
                </div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">文章内容：</label>
			<div class="formControls col-xs-8 col-sm-9"> 
				<div id="ueditor" name="content" class="edui-default">
                    @include('UEditor::head')
                </div>
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 提交审核</button>
				<button onClick="article_save();" class="btn btn-secondary radius" type="button"><i class="Hui-iconfont">&#xe632;</i> 保存草稿</button>
				<button onClick="removeIframe();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
			</div>
		</div>
	</form>
</article>
@endsection
@section('js')

<script type="text/javascript" src="{{URL::asset('lib/jquery.validation/1.14.0/jquery.validate.js')}}"></script> 
<script type="text/javascript" src="{{URL::asset('lib/jquery.validation/1.14.0/validate-methods.js')}}"></script> 
<script type="text/javascript" src="{{URL::asset('lib/jquery.validation/1.14.0/messages_zh.js')}}"></script>
<script id="ueditor"></script>
<script type="text/javascript">
var ue=UE.getEditor("ueditor");
ue.ready(function(){
     ue.setHeight(400);
     ue.setContent('{!! $article->content !!}');
});
$("#img_button").click(function(){
	$("#file0").click();
})
$("#file0").change(function(){  
      // getObjectURL是自定义的函数，见下面  
      // this.files[0]代表的是选择的文件资源的第一个，因为上面写了 multiple="multiple" 就表示上传文件可能不止一个  
      // ，但是这里只读取第一个   
      var objUrl = getObjectURL(this.files[0]) ;  
      // 这句代码没什么作用，删掉也可以  
      // console.log("objUrl = "+objUrl) ;  
      if (objUrl) {  
        // 在这里修改图片的地址属性  
        $("#img0").attr("src", objUrl) ; 
      }  
}) ;  
//建立一個可存取到該file的url  
function getObjectURL(file) {  
  var url = null ;   
  // 下面函数执行的效果是一样的，只是需要针对不同的浏览器执行不同的 js 函数而已  
  if (window.createObjectURL!=undefined) { // basic  
    url = window.createObjectURL(file) ;  
  } else if (window.URL!=undefined) { // mozilla(firefox)  
    url = window.URL.createObjectURL(file) ;  
  } else if (window.webkitURL!=undefined) { // webkit or chrome  
    url = window.webkitURL.createObjectURL(file) ;  
  }  
  return url ;  
}  
$(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});
	
	//表单验证
	$("#form-article-add").validate({
		rules:{
			title:{
				required:true,
				rangelength:[1,100],
			},
			classid:{
				required:true,
			},
			articletype:{
				required:true,
			},
			articlesort:{
				required:true,
			},
			auther:{
				required:true,
				rangelength:[0,50],
			},
			from:{
				required:true,
				rangelength:[0,50],
			},
			sources:{
				required:true,
			},
			browse:{
				min:0,
				max:100000000
			},
			px:{
				min:0,
				max:255
			}

		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
            $(form).ajaxSubmit({
                type: 'post', // 提交方式 get/post
                url: "{{route('admin.article_edit',['id'=>$article->id])}}", // 需要提交的 url
                data: $('form').serializeArray(),
                success: function(data) { // data 保存提交后返回的数据，一般为 json 数据
                    // 此处可对 data 作相关处理
                    if(data.code == 200){
                    	layer.msg(data.msg,{icon: 1});
                    	setTimeout(function(){
                    		window.location.href = "{{route('admin.article_list')}}";
                        },1500)
                    }else{
                    	layer.msg(data.msg,{icon: 2});
                    }
                    
                },error:function(error){
                	var json=JSON.parse(error.responseText);
                    $.each(json.errors, function(idx, obj) {
                        layer.msg(obj[0]);
                        return false;
                    });
                }
            });
            return false; // 阻止表单自动提交事件，必须返回false，否则表单会自己再做一次提交操作，并且页面跳转
			
			var index = parent.layer.getFrameIndex(window.name);
			//parent.$('.btn-refresh').click();
			parent.layer.close(index);
		}
	});
	
	$list = $("#fileList"),
	$btn = $("#btn-star"),
	state = "pending";

	
	
});
</script>
@endsection