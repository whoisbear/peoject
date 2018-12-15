@extends('admin._meta')
@section('common')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 资讯管理 <span class="c-gray en">&gt;</span> 资讯列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <form method="get">
	<div class="text-c">
		<button onclick="removeIframe()" class="btn btn-primary radius">关闭选项卡</button>
	 <span class="select-box inline">
		<select name="classid" class="select">
		  <option value="0" @if(session('classid') == 0) selected @endif >全部分类</option>
		@foreach($classify as $v)
			<option value="{{$v->id}}"  @if(session('classid') == $v->id) selected @endif>{{$v->name}}</option>
		@endforeach
		</select>
		</span> 日期范围：
		<input type="text" name="start_time" value="{{session('start_time')}}" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}' })" id="logmin" class="input-text Wdate" style="width:120px;">
		-
		<input type="text" name="end_time" value="{{session('end_time')}}" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'logmin\')}'})" id="logmax" class="input-text Wdate" style="width:120px;">
		<input type="text" name="name" value="{{session('name')}}" placeholder=" 资讯名称" style="width:250px" class="input-text">
		<button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜资讯</button>
	</div>
	</form>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="article_del_more()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a class="btn btn-primary radius" data-title="添加资讯" data-href="{{route('admin.article_add')}}" onclick="Hui_admin_tab(this)" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加资讯</a></span> <span class="r">共有数据：<strong>{{$count}}</strong> 条</span> </div>
	<div class="mt-20">
		<table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
			<thead>
				<tr class="text-c">
					<th width="25"><input type="checkbox" name="" value=""></th>
					<th width="80">ID</th>
					<th>标题</th>
					<th width="80">分类</th>
					<th width="80">来源</th>
					<th width="120">更新时间</th>
					<th width="75">浏览次数</th>
					<th width="60">发布状态</th>
					<th width="120">操作</th>
				</tr>
			</thead>
			<tbody>
			@foreach($list as $v)
				<tr class="text-c">
					<td><input type="checkbox" value="{{$v->id}}" name="ids"></td>
					<td>{{$v->id}}</td>
					<td class="text-l"><u style="cursor:pointer" class="text-primary" onClick="article_edit('查看','{{route('admin.article_add')}}','{{$v->id}}')" title="查看">{{$v->title}}</u></td>
					<td>{{$v->article_classify->name}}</td>
					<td>{{$v->from}}</td>
					<td>{{$v->updated_at}}</td>
					<td>{{$v->browse}}</td>
					<td class="td-status">
					@if($v->state == 1)
					   <span class="label label-success radius">已发布</span>
					@else
					   <span class="label label-defaunt radius">已下架</span>
					@endif   
					</td>
					<td class="f-14 td-manage">
					@if($v->state == 1)
					   <a style="text-decoration:none" a-id="{{$v->id}}" class="article_state" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a>
					@else
					   <a style="text-decoration:none" a-id="{{$v->id}}" class="article_state" href="javascript:;" title="发布"><i class="Hui-iconfont">&#xe603;</i></a>
					@endif   
					   <a style="text-decoration:none" class="ml-5" onClick="article_edit('资讯编辑','{{route('admin.article_update',['id'=>$v->id])}}','10001')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onClick="article_del(this,{{$v->id}})" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
				</tr>
			@endforeach	
			</tbody>
		</table>
	</div>
	{{$list->links()}}
</div>
@endsection
@section('js')
<script type="text/javascript" src="{{URL::asset('lib/My97DatePicker/4.8/WdatePicker.js')}}"></script> 
<script type="text/javascript" src="{{URL::asset('lib/datatables/1.10.0/jquery.dataTables.min.js')}}"></script> 
<script type="text/javascript" src="{{URL::asset('lib/laypage/1.2/laypage.js')}}"></script>
<script type="text/javascript">
$('.table-sort').dataTable({
	"aaSorting": [[ 1, "desc" ]],//默认第几个排序
	"bStateSave": true,//状态保存
	"pading":false,
	"aoColumnDefs": [
	  //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
	  {"orderable":false,"aTargets":[0,8]}// 不参与排序的列
	],
	"bPaginate": false,
	"bInfo": false,
});

/*资讯-添加*/
function article_add(title,url,w,h){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}
/*资讯-编辑*/
function article_edit(title,url,id,w,h){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}
/*资讯-删除*/
function article_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'POST',
			url: "{{route('admin.article_delete')}}",
			dataType: 'json',
			data:{id:id,_method:'delete'},
			success: function(data){
				if(data.code == 200){
					$(obj).parents("tr").remove();
					layer.msg(data.msg,{icon:5,time:1000});
				}else{
					layer.msg(data.msg,{icon:6,time:1000});
				}
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}
/*批量删除*/
function article_del_more(){
	var ids = [];
	layer.confirm('确认要批量删除吗？',function(index){
		$('input[name=ids]:checked').each(function() {
			ids.push($(this).val());
        });
		if(ids == ''){
			layer.msg('请选择删除项',{icon:5,time:1000});
		}else{
			$.post("{{route('admin.article_delete')}}",{id:ids,'_method':'delete'},function(data){
				if(data.code == 200){
					layer.msg(data.msg,{icon:6,time:1000});
					setTimeout(function(){
						window.location.href = "{{route('admin.article_list')}}";
					},1500)
				}else{
					layer.msg(data.msg,{icon:5,time:1000});
				}
				
			})
		}
	});
}


/*资讯-审核*/
function article_shenhe(obj,id){
	layer.confirm('审核文章？', {
		btn: ['通过','不通过','取消'], 
		shade: false,
		closeBtn: 0
	},
	function(){
		$(obj).parents("tr").find(".td-manage").prepend('<a class="c-primary" onClick="article_start(this,id)" href="javascript:;" title="申请上线">申请上线</a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已发布</span>');
		$(obj).remove();
		layer.msg('已发布', {icon:6,time:1000});
	},
	function(){
		$(obj).parents("tr").find(".td-manage").prepend('<a class="c-primary" onClick="article_shenqing(this,id)" href="javascript:;" title="申请上线">申请上线</a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-danger radius">未通过</span>');
		$(obj).remove();
    	layer.msg('未通过', {icon:5,time:1000});
	});	
}
$(".article_state").click(function(){
	var thiss = $(this);
	var id = thiss.attr('a-id');
	layer.confirm('确认要'+thiss.attr('title')+'吗？',function(index){
		$.post("{{route('admin.article_state')}}",{id:id},function(data){
			if(data.code == 200){
				if(thiss.attr('title') == '下架'){
					thiss.attr('title','发布');
					thiss.find('.Hui-iconfont').html('&#xe603;');
					thiss.parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已下架</span>');
				}else{
					thiss.attr('title','下架');
					thiss.find('.Hui-iconfont').html('&#xe6de;');
					thiss.parents("tr").find(".td-status").html('<span class="label label-success radius">已发布</span>');
				}
				layer.msg(data.msg,{icon: 6,time:1000});
			}else{
				layer.msg(data.msg,{icon: 5,time:1000});
			}
		})
	});
})
/*资讯-申请上线*/
function article_shenqing(obj,id){
	$(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">待审核</span>');
	$(obj).parents("tr").find(".td-manage").html("");
	layer.msg('已提交申请，耐心等待审核!', {icon: 1,time:2000});
}

</script>
@endsection
