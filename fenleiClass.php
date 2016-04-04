<?php
$cz = $_GET['cz'];
$fl_data = getfenlei();
$dflid = $_GET['dflid'];
if($dflid == ''){
	$dflid = $_POST['dflid'];
}
if($dflid != null){
	foreach ($fl_data as $vo){
		//var_dump($vo);
		if($vo['quanxian']==555 and $vo['ID']==$dflid or $user_info['quanxian'] == 777 and $vo['ID']==$dflid or $user_info['quanxian'] == 555 and $vo['ID']==$dflid){
			$qx = 999;
			$dflname = $vo['name'];
			break;
		};
	}
}
switch ($cz) {
	case 'get':
		if($dflid != null){
			if($qx == 999 or $qx == 777){
				$fl_data = getfenlei($dflid);
			}else{
				echo '<h1>您无权执行此操作</h1>';
				exit;
			};
		}
		break;
	case 'set':
		$url=$_SERVER["HTTP_REFERER"];
		$dflid = $_GET['dflid'];
		$name = $_POST['name'];
		$quanxian = $_POST['quanxian'];
		$id = $_POST['id'];
		//var_dump($_POST);
		if($dflid != null){
			addfenlei($name,null,$dflid,$id);
		}else{
			addfenlei($name,$quanxian,null,$id);
		}
		$fl_data = getfenlei();
		header("Location:".$url); 
		echo '<meta http-equiv="refresh" content="0;url='.$url.'"> ';
		break;
	case 'add':
		$url=$_SERVER["HTTP_REFERER"];
		$dflid = $_GET['dflid'];
		if($dflid == ''){
			$dflid = $_POST['dflid'];
		}
		$name = $_POST['name'];
		$quanxian = $_POST['quanxian'];
		if($dflid != null){
			addfenlei($name,null,$dflid);
		}else{
			addfenlei($name,$quanxian);
		}
		$fl_data = getfenlei();
		header("Location:".$url); 
		echo '<meta http-equiv="refresh" content="0;url='.$url.'"> ';
		break;
	case 'del':
		$url=$_SERVER["HTTP_REFERER"];
		$dflid = $_GET['dflid'];
		$flid = $_POST['id'];
		if($dflid != null){
			delfenlei($dflid,$flid);
		}else{
			delfenlei($flid);
		}
		$fl_data = getfenlei();
		header("Location:".$url); 
		echo '<meta http-equiv="refresh" content="0;url='.$url.'"> ';
		break;
}
//$ck_data = getuser($quanxian);
//$cj_data = getuser($quanxian);
?>
<div class="am-cf am-padding" style="padding-bottom:0">
	<div class="am-fl am-cf"><a href="admin.php"><strong class="am-text-primary am-text-lg">首页</strong></a> / 
	<?php
	if($cz != 'get'){
		echo '<small>分类管理</small>';
	}else{
		echo '<a href="admin.php?act=fenlei"><strong>分类管理</strong></a> / <small>'.$dflname.' 管理</small>';
	}
	?>
	</div>
</div>
<div class="am-padding" style="padding-top:0">
	<?php
	if($user_info['quanxian'] == 777 or $user_info['quanxian'] == 555){
	?>
		<button data-u="fl" type="button" style="margin-left: 0;margin-right: 0;" class="am-btn am-btn-primary am-margin add" data-am-modal="{target: '#add', width: 240}" >
			<?php
				if($cz == 'get'){ echo '在当前分类添加产品'; }else{ echo '添加分类'; }
			?>
		</button>
	<?php
		if($cz != 'get'){
	?>
			<button data-u="cp" type="button" class="am-btn am-btn-primary am-margin add" data-am-modal="{target: '#addcp', width: 240}" >添加产品</button>
	<?php
	}
	?>
		
	<?php
	}
	?>
	<table class="usreinfo am-table am-table-bd am-table-striped am-table-hover admin-content-table am-table-bordered <?php if($dflid != ''){ echo 'am-animation-slide-right'; } ?>"><!-- style="display:none;"-->
		<thead>
	        <tr>
	            <th width="70" align="center">分类ID</th>
	            <th align="center">分类名称</th>
	            <?php
				if($user_info['quanxian'] == 777 or $user_info['quanxian'] == 555 ){
				?>
	            <th width="180" align="center">管理</th>
	            <?php
				}
				?>
	        </tr>
	    </thead>
	    <tbody>
	    	<?php 
				if($fl_data == null){
					$fl_data[] = array('name' => '暂无数据,请添加数据');
				};
	    	foreach ($fl_data as $vo){
	    		//echo $vo['name'],"|",$user_info['quanxian'],"<br/>";
	    		if($user_info['quanxian'] == 777 or $user_info['quanxian'] == 555 ){
	    	?>
	    	<tr data-u="<?php echo $vo['ID']; ?>" data-qx="<?php echo $vo['quanxian'] ?>">
	            <td data-u="<?php echo $vo['ID']; ?>"><?php echo $vo['ID']; ?></td>
	            <td data-u="<?php echo $vo['name']; ?>"><?php echo $vo['name']; ?></td>
	            <td align="center">
					<div class="am-btn-group">
						<a class="am-btn am-radius am-btn-xs am-btn-warning set" href="#">编辑</a>
						<?php
						if($cz != 'get'){
						?>
						<a class="am-btn am-radius am-btn-xs am-btn-success see" href="?act=fenlei&cz=get&dflid=<?php echo $vo['ID']; ?>">查看</a>
						<?php
						}
						?>
						<a class="am-btn am-radius am-btn-xs am-btn-danger del" href="#">删除</a>
					</div>
	            </td>
	        </tr>
	    	<?php
	    		}elseif($vo['quanxian'] == 555 or $qx==999){
	    	?>
	    	<tr data-u="<?php echo $vo['ID']; ?>">
	            <td data-u="<?php echo $vo['ID']; ?>"><?php echo $vo['ID']; ?></td>
	            <td data-u="<?php echo $vo['name']; ?>"><?php echo $vo['name']; ?></td>

	            <?php
				if($user_info['quanxian'] == 777){
				?>
	            <td align="center">
					<div class="am-btn-group">
						<a class="am-btn am-radius am-btn-xs am-btn-warning set" href="#">编辑</a>
						<?php
						if($dflname == null){
						?>
						<a class="am-btn am-radius am-btn-xs am-btn-success see" href="?act=fenlei&cz=get&dflid=<?php echo $vo['ID']; ?>">查看</a>
						<?php
						}
						?>
						<a class="am-btn am-radius am-btn-xs am-btn-danger del" href="#">删除</a>
					</div>
	            </td>
	            <?php
				}
				?>
	        </tr>
	    	<?php
	    		}
	    	}
	    	?>
	    </tbody>
	</table>
</div>

<?php
if($user_info['quanxian'] == 777 or $user_info['quanxian'] == 555){
?>
<div class="am-modal am-modal-no-btn" tabindex="-1" id="add">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">添加分类数据
      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
    </div>
    <div class="am-modal-bd">
      <form method="post" class="am-form" action="?act=fenlei&cz=add<?php if($dflid != null){ echo '&dflid='.$dflid; } ?>">
      	<div class="am-form-group">
      		<input name="name" type="text" value="" placeholder="请输入分类名称"></input>
      	</div>
      	<?php
      	if($dflid != null){
      	?>
      	<div class="am-form-group">
      		<label class="am-form-label" for="doc-ipt-success">上级分类</label>
      		<input name="dafenlei" type="text" placeholder="<?php echo $dflname; ?>" disabled></input>
      	</div>
      	<div class="am-form-group" style="display:none;">
      		<input name="dflid" type="text" value="<?php echo $dflid; ?>" placeholder="" disabled></input>
      	</div>
      	<?php
      	}else{
      	?>
      	<div class="am-form-group">
			<label>请选择下属可否查看</label>
	      	<select name="quanxian">
	      	<option value="0">不可查看</option>
	      	<option value="555">可以查看</option>
	      	</select>
	      	<span class="am-form-caret"></span>
	    </div>
      	<?php
      	}
      	?>
      	<button type="submit" class="am-btn am-btn-success am-radius">提交</button>
      </form>
    </div>
  </div>
</div>



<div class="am-modal am-modal-no-btn" tabindex="-1" id="addcp">
  <div class="am-modal-dialog">
  	<?php
  	if($user_info['quanxian'] == 777 or $user_info['quanxian'] == 555){
  	?>
    <div class="am-modal-hd">添加产品
      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
    </div>
  	<?php
  	}?>
    <div class="am-modal-bd">
      <form method="post" class="am-form" action="?act=fenlei&cz=add">
      	<div class="am-form-group">
      		<input name="name" type="text" value="" placeholder="请输入分类名称"></input>
      	</div>
      	<div class="am-form-group">
      		<label class="am-form-label" for="doc-ipt-success">所属分类</label>
						<select name="dflid">
						<?php
						foreach ($fl_data as $vo){
						?>
							<option value="<?php echo $vo['ID']; ?>"><?php echo $vo['name']; ?></option>
						<?php
						}
						?>
						</select>
      	</div>
      	<button type="submit" class="am-btn am-btn-success am-radius">提交</button>
      </form>
    </div>
  </div>
</div>

<div class="am-modal am-modal-no-btn" tabindex="-1" id="set">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">修改分类数据
      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
    </div>
    <div class="am-modal-bd">
      <form method="post" class="am-form" action="?act=fenlei&cz=set<?php if($dflid != null){ echo '&dflid='.$dflid; } ?>">
      	<div class="am-form-group">
      		<input name="name" type="text" value="" placeholder="请输入分类名称"></input>
      	</div>
      	<?php
      	if($dflid != null){
      	?>
      	<div class="am-form-group">
      		<label class="am-form-label" for="doc-ipt-success">上级分类</label>
      		<input name="dafenlei" type="text" placeholder="<?php echo $dflname; ?>" disabled></input>
      	</div>
      	<div class="am-form-group" style="display:none;">
      		<input name="dflid" type="text" value="<?php echo $dflid; ?>" placeholder=""></input>
      		
      	</div>
      	<?php
      	}
      	?>
      	<input name="id" type="text" value="" style="display:none;"></input>
      	<?php
      	if($dflid == null){
      	?>
      	<div class="am-form-group">
			<label>请选择下属可否查看</label>
	      	<select name="quanxian">
	      	<option value="0">不可查看</option>
	      	<option value="555">可以查看</option>
	      	</select>
	      	<span class="am-form-caret"></span>
	    </div>
      	<?php
      	}
      	?>
      	<button type="submit" class="am-btn am-btn-success am-radius">提交</button>
      </form>
    </div>
  </div>
</div>

<div class="am-modal am-modal-no-btn" tabindex="-1" id="del">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">确定删除分类数据
      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
    </div>
    <div class="am-modal-bd">
      <form method="post" class="am-form" action="?act=fenlei&cz=del<?php if($dflid != null){ echo '&dflid='.$dflid; } ?>">
      	<div class="am-form-group" style="display:none;">
      		<input name="id" type="text"></input>
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
		quanxian = $(this).parents("tr").data("qx");
		//var_dump(id+"|"+name+"|"+quanxian);
		$("#set *[name=id]").val(id);
		$("#set *[name=name]").val(name);
		$("#set *[name=quanxian]").val(quanxian);
		$('#set').modal({width:240});
		return false;
	})
	$('tbody .del').click(function(){
		var id,name,html;
		id = $(this).parents("tr").find("td:eq(0)").data("u");
		name = $(this).parents("tr").find("td:eq(1)").data("u");
		<?php
		if($cz == 'get'){
		?>
		html = "上级分类:<?php echo $dflname; ?><br/>";
		html += "当前分类ID:"+id+"<br/>";
		<?php
		}else{
		?>
		html = "当前分类ID:"+id+"<br/>";
		<?php
		}
		?>
		html += "分类名称:"+name;
		$("#del *[name=id]").attr("value",id);
		$("#del .tips-text").html(html);
		$('#del').modal({width:240});
		return false;
	})
</script>
<?php
}
?>