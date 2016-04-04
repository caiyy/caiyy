<?php
if($user_info['quanxian'] != 777){
	echo '<h1>您无权执行此操作</h1>';
	exit;
}
$cz = $_GET['cz'];
$ckid = $_GET['ckid'];
switch ($cz) {
	case 'del':
		$url=$_SERVER["HTTP_REFERER"];
		$id = $_POST['id'];
		delcangku($id);
		delcangku(null,$id);
		header("Location:".$url); 
		echo '<meta http-equiv="refresh" content="0;url='.$url.'">';
		break;
	case 'set':
		$url=$_SERVER["HTTP_REFERER"];
		$id = $_POST['id'];
		$name = $_POST['name'];
		if($ckid == null){
			addcangku($name,$id);
		} else {
			addcangku($name,$id,$ckid);
		}
		header("Location:".$url); 
		echo '<meta http-equiv="refresh" content="0;url='.$url.'">';
		break;
	case 'add':
		$url=$_SERVER["HTTP_REFERER"];
		$name = $_POST['name'];
		if($ckid == null){
			addcangku($name);
		} else {
			addcangku($name,null,$ckid);
		}
		header("Location:".$url); 
		echo '<meta http-equiv="refresh" content="0;url='.$url.'">';
		break;
}
if($ckid != null){
	$ck_ = getcangku(null,null,$ckid);
}else{
	$ck_ = getcangku();
}
$ck_data = $ck_['data'];
?>
<div class="am-cf am-padding" style="padding-bottom:0">
	<div class="am-fl am-cf"><a href="admin.php"><strong class="am-text-primary am-text-lg">首页</strong></a> / 
	<?php
	if($cz != 'get'){
		echo '<small>仓库管理</small>';
	}else{
		echo '<a href="admin.php?act=changku"><strong>仓库管理</strong></a> / <small>'.$dflname.' 管理</small>';
	}
	?>
	</div>
</div>
<div class="am-padding" style="padding-top:0">
	<button type="button" style="margin-left: 0;margin-right: 0;" class="am-btn am-btn-primary am-margin add" data-am-modal="{target: '#add', width: 240}" ><?php if($ckid == null){ echo "添加仓库"; }else{echo "添加仓库位置到该仓库";} ?></button>
	<table class="usreinfo am-table am-table-bd am-table-striped am-table-hover admin-content-table am-table-bordered"><!-- style="display:none;"-->
		<thead>
	        <tr>
	            <th width="70" align="center">仓库ID</th>
	            <th align="center">仓库名称</th>
	            <th width="<?php if($ckid==null){echo "220";}else{echo "180";} ?>" align="center">管理</th>
	        </tr>
	    </thead>
	    <tbody>
	    	<?php  
				if($ck_data == null){
					$ck_data[1] = array('name' => '暂无数据,请添加数据');
				};
	    	foreach ($ck_data as $vo){
	    	?>
	    	<tr data-u="<?php echo $vo['ID']; ?>" data-qx="<?php echo $vo['quanxian'] ?>">
	            <td data-u="<?php echo $vo['ID']; ?>"><?php echo $vo['ID']; ?></td>
	            <td data-u="<?php echo $vo['name']; ?>"><?php echo $vo['name']; ?></td>
	            <td align="center">
					<div class="am-btn-group">
						<a class="am-btn am-radius am-btn-xs am-btn-warning set" href="#">编辑</a>
						<?php
						if($ckid == null){
						?>
						<a class="am-btn am-radius am-btn-xs am-btn-success see" href="?act=changku&cz=get&ckid=<?php echo $vo['ID']; ?>">位置管理</a>
						<?php
						}
						?>
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
    <div class="am-modal-hd">添加仓库
      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
    </div>
    <div class="am-modal-bd">
      <form method="post" class="am-form" action="?act=changku&cz=add<?php if($ckid!=null){ echo "&ckid=".$ckid; } ?>">
      	<div class="am-form-group">
      		<input name="name" type="text" value="" placeholder="请输入仓库名称"></input>
      	</div>
      	<button type="submit" class="am-btn am-btn-success am-radius">提交</button>
      </form>
    </div>
  </div>
</div>

<div class="am-modal am-modal-no-btn" tabindex="-1" id="set">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">修改仓库
      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
    </div>
    <div class="am-modal-bd">
      <form method="post" class="am-form" action="?act=changku&cz=set<?php if($ckid!=null){ echo "&ckid=".$ckid; } ?>">
      	<div class="am-form-group">
      		<input name="name" type="text" value="" placeholder="请输入仓库名称"></input>
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
    <div class="am-modal-hd">确定删除仓库
      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
    </div>
    <div class="am-modal-bd">
      <form method="post" class="am-form" action="?act=changku&cz=del<?php if($ckid!=null){ echo "&ckid=".$ckid; } ?>">
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
		html = "当前仓库ID:"+id+"<br/>";
		html += "仓库名称:"+name;
		$("#del *[name=id]").attr("value",id);
		$("#del .tips-text").html(html);
		$('#del').modal({width:240});
		return false;
	})
</script>