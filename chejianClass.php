<?php
if($user_info['quanxian'] != 777){
	echo '<h1>您无权执行此操作</h1>';
	exit;
}
$cz = $_GET['cz'];
switch ($cz) {
	case 'del':
		$id = $_POST['id'];
		delchejian($id);
		break;
	case 'set':
		$id = $_POST['id'];
		$name = $_POST['name'];
		addchejian($name,$id);
		break;
	case 'add':
		$name = $_POST['name'];
		addchejian($name);
		break;
}
$cj_data = getchejian();
?>
<div class="am-cf am-padding" style="padding-bottom:0">
	<div class="am-fl am-cf"><a href="admin.php"><strong class="am-text-primary am-text-lg">首页</strong></a> / 
	<?php
	if($cz != 'get'){
		echo '<small>车间管理</small>';
	}else{
		echo '<a href="admin.php?act=fenlei"><strong>车间管理</strong></a> / <small>'.$dflname.' 管理</small>';
	}
	?>
	</div>
</div>
<div class="am-padding" style="padding-top:0">
	<button type="button" style="margin-left: 0;margin-right: 0;" class="am-btn am-btn-primary am-margin add" data-am-modal="{target: '#add', width: 240}" >添加车间</button>
	<table class="usreinfo am-table am-table-bd am-table-striped am-table-hover admin-content-table am-table-bordered"><!-- style="display:none;"-->
		<thead>
	        <tr>
	            <th width="70" align="center">车间ID</th>
	            <th align="center">车间名称</th>
	            <th width="180" align="center">管理</th>
	        </tr>
	    </thead>
	    <tbody>
	    	<?php  
				if($cj_data == null){
					$cj_data[] = array('name' => '暂无数据,请添加数据');
				};
	    	foreach ($cj_data as $vo){
	    	?>
	    	<tr data-u="<?php echo $vo['ID']; ?>" data-qx="<?php echo $vo['quanxian'] ?>">
	            <td data-u="<?php echo $vo['ID']; ?>"><?php echo $vo['ID']; ?></td>
	            <td data-u="<?php echo $vo['name']; ?>"><?php echo $vo['name']; ?></td>
	            <td align="center">
					<div class="am-btn-group">
						<a class="am-btn am-radius am-btn-xs am-btn-warning set" href="#">编辑</a>
						<a class="am-btn am-radius am-btn-xs am-btn-danger del" href="#">删除</a>
					</div>
	            </td>
	        </tr>
	    	<?php
	    	}
	    	?>
	    </tbody>
	</table>
</div>

<div class="am-modal am-modal-no-btn" tabindex="-1" id="add">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">添加车间
      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
    </div>
    <div class="am-modal-bd">
      <form method="post" class="am-form" action="?act=chejian&cz=add">
      	<div class="am-form-group">
      		<input name="name" type="text" value="" placeholder="请输入车间名称"></input>
      	</div>
      	<button type="submit" class="am-btn am-btn-success am-radius">提交</button>
      </form>
    </div>
  </div>
</div>

<div class="am-modal am-modal-no-btn" tabindex="-1" id="set">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">修改车间
      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
    </div>
    <div class="am-modal-bd">
      <form method="post" class="am-form" action="?act=chejian&cz=set">
      	<div class="am-form-group">
      		<input name="name" type="text" value="" placeholder="请输入车间名称"></input>
      	</div>
      	<div class="am-form-group" style="display:none;">
      		<input name="id" value type="text"></input>
      	</div>
      	<button type="submit" class="am-btn am-btn-success am-radius">提交</button>
      </form>
    </div>
  </div>
</div>

<div class="am-modal am-modal-no-btn" tabindex="-1" id="del">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">确定删除车间
      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
    </div>
    <div class="am-modal-bd">
      <form method="post" class="am-form" action="?act=chejian&cz=del">
      	<div class="am-form-group" style="display:none;">
      		<input name="id" type="text" value></input>
      	</div>
      	<h2 class="tips-text"></h2>
      	<div class="am-btn-group">
		    <a class="am-btn am-btn-default" href="javascript:$('#del').modal('close')">取消</a>
		    <button type="submit" class="am-btn am-btn-success">确定</button>
      	</div>
      </form>
    </div>
  </div>
</div>

<script>
	$('tbody .set').click(function(){
		var id,name;
		id = $(this).parents("tr").find("td:eq(0)").data("u");
		name = $(this).parents("tr").find("td:eq(1)").data("u");
		//var_dump(id+"|"+name);
		//$("#set *[name=id]").val(id);
		$("#set *[name=id]").attr("value",id);
		$("#set *[name=name]").val(name);
		$('#set').modal({width:240});
		return false;
	})
	$('tbody .del').click(function(){
		var id,name,html;
		id = $(this).parents("tr").find("td:eq(0)").data("u");
		name = $(this).parents("tr").find("td:eq(1)").data("u");
		html = "当前车间ID:"+id+"<br/>";
		html += "车间名称:"+name;
		$("#del *[name=id]").attr("value",id);
		$("#del .tips-text").html(html);
		$('#del').modal({width:240});
		return false;
	})
</script>