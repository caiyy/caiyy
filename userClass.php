<?php
if($juri != 777){
	echo '<h1>您无权执行此操作</h1>';
	exit;
}
$user_data = array();
$cz = $_GET['cz'];
$re = -555;
switch ($cz) {
	case 'add':
		$name = $_POST['name'];
		$pass = md5($_POST['pass']);
		$quanxian = $_POST['quanxian'];
		$ck = $_POST['ck'];
		$cj = $_POST['cj'];
		if($name != null and $pass != 'd41d8cd98f00b204e9800998ecf8427e' and $quanxian != null){
			$re = adduser($name,$pass,$quanxian,$ck,$cj);
		}else{
			$re = 555;
		}
		break;
	case 'get':
		$quanxian = $_GET['quanxian'];
		$user_data = getuser($quanxian);
		break;
	case 'set':
		$id = $_POST['id'];
		$name = $_POST['name'];
		$pass = md5($_POST['pass']);
		$quanxian = $_POST['quanxian'];
		$ck = $_POST['ck'];
		$cj = $_POST['cj'];
		$re = adduser($name,$pass,$quanxian,$ck,$cj,$id);
		break;
	case 'del':
		$id = $_POST['id'];
		deluser($id);
		break;
}
$ck_ = getcangku();
//var_dump($ck_['data']);
$ck_data = $ck_['data'];
$cj_data = getchejian();
?>
<div class="am-cf am-padding" style="padding-bottom:0">
	<div class="am-fl am-cf"><a href="/admin.php"><strong class="am-text-primary am-text-lg">首页</strong></a> / <small>用户管理</small></div>
</div>
<div class="am-padding" style="padding-top:0">
	<div class="am-dropdown" data-am-dropdown>
		<button class="am-btn am-btn-primary am-dropdown-toggle am-margin" style="margin-left: 0;margin-right: 0;" id="cxuser" data-am-dropdown-toggle> 查询用户 <span class="am-icon-caret-down"></span></button>
		<ul class="cxuser am-dropdown-content">
			<li><a href="admin.php?act=user&cz=get&quanxian=1" data-num="1">查询所有用户</a></li>
			<li><a href="admin.php?act=user&cz=get&quanxian=2" data-num="2">查询系统管理</a></li>
			<li><a href="admin.php?act=user&cz=get&quanxian=3" data-num="3">查询车间管理</a></li>
			<li><a href="admin.php?act=user&cz=get&quanxian=4" data-num="4">查询仓库管理</a></li>
			<li><a href="admin.php?act=user&cz=get&quanxian=5" data-num="5">查询观察员</a></li>
		</ul>
	</div>
	<button type="button" class="am-btn am-btn-primary am-margin add" data-am-modal="{target: '#add', width: 240}" >添加用户</button>
	<?php
	if($re != -555){
	?>
	<div class="am-alert am-alert-success" data-am-alert>
		<button type="button" class="am-close">&times;</button>
	<?php
		switch ($re) {
			case -1:
				echo '添加失败';
				break;
			case 0:
				echo '用户 '.$name.' 已存在';
				break;
			case 1:
				echo '添加用户 '.$name.' 成功';
				break;
			case 2:
				echo '修改用户 '.$name.' 成功';
				break;
			case 555:
				echo '请填写完必要信息';
				break;
		}
	?>
	</div>
	<?php
	}
	?>
	<table class="usreinfo am-table am-table-bd am-table-striped am-table-hover admin-content-table am-table-bordered" <?php if($cz!=get){ echo 'style="display:none;"';} ?>><!-- style="display:none;"-->
		<thead>
	        <tr>
	            <th width="70" align="center">用户ID</th>
	            <th align="center">用户名</th>
	            <th width="100" align="center">用户权限</th>
	            <th>所属仓库</th>
	            <th>所属车间</th>
	            <th width="180" align="center">最后活动时间</th>
	            <th width="150" align="center">管理</th>
	        </tr>
	    </thead>
	    <tbody>
	    	<?php
				if($user_data == null){
					$user_data = array();
				};
	    	foreach ($user_data as $vo){
	    	?>
	        <tr data-u="<?php echo $vo['ID']; ?>">
	            <td data-u="<?php echo $vo['ID']; ?>"><?php echo $vo['ID']; ?></td>
	            <td data-u="<?php echo $vo['name']; ?>"><?php echo $vo['name']; ?></td>
	            <td data-u="<?php echo $vo['quanxian']; ?>"><?php echo $user_qx[$vo['quanxian']]; ?></td>
	            <td data-u="<?php echo $vo['ck']; ?>">
	            <?php
							/*
	            foreach ($ck_data as $value) {
	            	if ($value['ID']==$vo['ck']){
									echo $value['name'];
								};
	            }
							*/
							echo $ck_data[$vo['ck']]['name'];
	            ?>
	            </td>
	            <td data-u="<?php echo $vo['cj']; ?>">
	            <?php
							/*
	            foreach ($cj_data as $value) {
	            	if ($value['ID']==$vo['cj']){
									echo $value['name'];
								};
	            }
							*/
							echo $cj_data[$vo['cj']]['name'];
	            ?>
	            </td>
	            <td align="center" data-u="<?php echo $vo['time']; ?>"><?php echo date('Y-m-d H:i:s', $vo['time']); ?></td>
	            <td align="center">
					<div class="am-btn-group">
					<?php
					if($vo['ID'] != $user_info['ID']){
					?>
						<a class="am-btn am-radius am-btn-xs am-btn-warning set" href="#">编辑</a>
						<a class="am-btn am-radius am-btn-xs am-btn-danger del" href="#">删除</a>
					<?php
					}else{
					?>
						<a class="am-btn am-radius am-btn-xs am-btn-warning set" href="#">编辑</a>
						<a class="am-btn am-radius am-btn-xs am-btn-danger am-disabled" href="#">删除</a>
					<?php
					}
					?>
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
    <div class="am-modal-hd">添加用户数据
      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
    </div>
    <div class="am-modal-bd">
      <form method="post" class="am-form" action="?act=user&cz=add">
      	<div class="am-form-group">
      		<input name="name" type="text" value="" placeholder="请输入用户名"></input>
      	</div>
      	<div class="am-form-group">
      		<input name="pass" type="text" value="" placeholder="请输入用户密码"></input>
      	</div>
      	<div class="am-form-group">
			<label>请选择用户权限</label>
	      	<select name="quanxian" class="qxqx">
<?php
	foreach ($user_qx as $fl_dd){
?>
				<option value="<?php echo array_search($fl_dd,$user_qx); ?>"><?php echo $fl_dd; ?></option>
<?php
	}
?>
	      	</select>
	      	<span class="am-form-caret"></span>
	    </div>
	    <div class="am-form-group">
			<label>请选择用户所属仓库</label>
	      	<select name="ck">
	      	<option value="0">总仓库</option>
<?php
	foreach ($ck_data as $cj_dd) {
?>
				<option value="<?php echo $cj_dd['ID']; ?>"><?php echo $cj_dd['name']; ?></option>			
<?php
	}
?>   
	      	</select>
	      	<span class="am-form-caret"></span>
	    </div>
      	<div class="am-form-group">
			<label>请选择用户所属车间</label>
	      	<select name="cj">
	      	<option value="0">总车间</option>
<?php
	foreach ($cj_data as $cj_dd) {
?>
				<option value="<?php echo $cj_dd['ID']; ?>"><?php echo $cj_dd['name']; ?></option>			
<?php
	}
?>   
	      	</select>
	      	<span class="am-form-caret"></span>
	    </div>
      	<button type="submit" class="am-btn am-btn-default">提交</button>
      </form>
    </div>
  </div>
</div>



<div class="am-modal am-modal-no-btn" tabindex="-1" id="set">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">修改用户数据
      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
    </div>
    <div class="am-modal-bd">
      <form method="post" class="am-form" action="?act=user&cz=set">
      	<div class="am-form-group">
      		<input name="name" type="text" value="" placeholder="请输入用户名"></input>
      	</div>
      	<div class="am-form-group">
      		<input name="pass" type="text" value="" placeholder="请输入用户密码"></input>
      	</div>
      	<div class="am-form-group">
			<label>请选择用户权限</label>
	      	<select name="quanxian" class="qxqx">
<?php
	foreach ($user_qx as $fl_dd){
?>
				<option value="<?php echo array_search($fl_dd,$user_qx); ?>"><?php echo $fl_dd; ?></option>
<?php
	}
?>
	      	</select>
	      	<span class="am-form-caret"></span>
	    </div>
	    <div class="am-form-group">
			<label>请选择用户所属仓库</label>
	      	<select name="ck">
	      	<option value="0">总仓库</option>
<?php
	//$cjdb = getchejian();
	foreach ($ck_data as $cj_dd) {
?>
				<option value="<?php echo $cj_dd['ID']; ?>"><?php echo $cj_dd['name']; ?></option>			
<?php
	}
?>   
	      	</select>
	      	<span class="am-form-caret"></span>
	    </div>
	    <div class="am-form-group">
			<label>请选择用户所属车间</label>
	      	<select name="cj">
	      	<option value="0">总车间</option>
<?php
	foreach ($cj_data as $cj_dd) {
?>
				<option value="<?php echo $cj_dd['ID']; ?>"><?php echo $cj_dd['name']; ?></option>			
<?php
	}
?>   
	      	</select>
	      	<span class="am-form-caret"></span>
	    </div>
      	<div class="am-form-group" style="display:none;">
      		<input name="id" type="text"></input>
      	</div>
      	<button type="submit" class="am-btn am-btn-default">提交</button>
      </form>
    </div>
  </div>
</div>



<div class="am-modal am-modal-no-btn" tabindex="-1" id="del">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">确定删除用户数据
      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
    </div>
    <div class="am-modal-bd">
      <form method="post" class="am-form" action="?act=user&cz=del">
      	<div class="am-form-group" style="display:none;">
      		<input class="id" name="id" type="text"></input>
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
	$('#add .qxqx').change(function(){
		var nam = $(this).val();
		if(nam == 666){
			$('#add *[name=ck] ,#add *[name=cj] ').val('0').attr('disabled',false);
			$('#add *[name=ck] *[value=0]').html('不可操作').show();
			$('#add *[name=cj] *[value=0]').html('总车间').hide();
			$('#add *[name=cj] option').eq(1).attr('selected',true);
		}else if(nam == 555){
			$('#add *[name=ck],#add *[name=cj]').val('0').attr('disabled',false);
			$('#add *[name=cj] *[value=0]').html('不可操作').show();
			$('#add *[name=ck] *[value=0]').html('总仓库').hide();
			$('#add *[name=ck] option').eq(1).attr('selected',true);
		}else if(nam == 777){
			$('#add *[name=ck],#add *[name=cj]').val('0').attr('disabled',true);
			$('#add *[name=ck] *[value=0]').html('总仓库').hide();
			$('#add *[name=cj] *[value=0]').html('总车间').hide();
		}else if(nam == 999){
			$('#add *[name=ck],#add *[name=cj]').val('0').attr('disabled',false);
			$('#add *[name=ck] *[value=0]').html('不可查看').show();
			$('#add *[name=cj] *[value=0]').html('不可查看').show();
		}
		//var_dump(nam);
	})
	$('#set .qxqx').change(function(){
		var nam = $(this).val();
		if(nam == 666){
			$('#set *[name=ck]').val('0').attr('disabled',false);
			$('#set *[name=ck] *[value=0]').html('不可操作').show();
			$('#set *[name=cj] *[value=0]').html('总车间').hide();
			$('#set *[name=cj] option').eq(1).attr('selected',true);
		}else if(nam == 555){
			$('#set *[name=cj]').val('0');
			$('#set *[name=cj] *[value=0]').html('不可操作').show();
			$('#set *[name=ck] *[value=0]').html('总仓库').hide();
			$('#set *[name=ck] option').eq(1).attr('selected',true);
		}else if(nam == 777){
			$('#set *[name=ck] *[value=0]').html('总仓库').show();
			$('#set *[name=cj] *[value=0]').html('总车间').show();
		}else if(nam == 999){
			$('#set *[name=ck],#set *[name=cj]').val('0').attr('disabled',false);
			$('#set *[name=ck] *[value=0]').html('不可查看').show();
			$('#set *[name=cj] *[value=0]').html('不可查看').show();
		}
		//var_dump(nam);
	})
	$('#add *[name=ck],#add *[name=cj]').attr('disabled',true);
	$('tbody .set').click(function(){
		var id,name,quanxian,ck,cj;
		id = $(this).parents("tr").find("td:eq(0)").data("u");
		name = $(this).parents("tr").find("td:eq(1)").data("u");
		quanxian = $(this).parents("tr").find("td:eq(2)").data("u");
		if(quanxian == 777){
			$('#set *[name=ck],#set *[name=cj]').attr('disabled',true);
		}else{
			$('#set *[name=ck],#set *[name=cj]').attr('disabled',false);
		}
		ck = $(this).parents("tr").find("td:eq(3)").data("u");
		cj = $(this).parents("tr").find("td:eq(4)").data("u");
		if( ck == "" ){ ck = 0 ; }
		if( cj == "" ){ cj = 0 ; }
		//var_dump(id+"|"+name+"|"+quanxian+"|"+ck+"|"+cj);
		$("#set *[name=id]").val(id);
		$("#set *[name=name]").val(name);
		$("#set *[name=quanxian]").val(quanxian);
		if(quanxian == 666){
			$('#set *[name=ck] *[value=0]').html('不可操作').show();
			$('#set *[name=cj] *[value=0]').html('总车间').hide();
		}else if(quanxian == 555){
			$('#set *[name=ck] *[value=0]').html('总仓库').hide();
			$('#set *[name=cj] *[value=0]').html('不可操作').show();
		}else if(quanxian == 777){
			$('#set *[name=ck] *[value=0]').html('总仓库').show();
			$('#set *[name=cj] *[value=0]').html('总车间').show();
		}else if(quanxian == 999){
			$('#set *[name=ck] *[value=0]').html('不可查看').show();
			$('#set *[name=cj] *[value=0]').html('不可查看').show();
		}
		$("#set *[name=ck]").val(ck);
		$("#set *[name=cj]").val(cj);
		$('#set').modal({width:240});
		
		
	
		
		
		return false;
	})
	$('tbody .del').click(function(){
		var id,name,html;
		id = $(this).parents("tr").find("td:eq(0)").data("u");
		name = $(this).parents("tr").find("td:eq(1)").data("u");
		html = "用户ID:"+id+"<br/>";
		html += "用户名:"+name;
		$("#del .id").attr("value",id);
		$("#del .tips-text").html(html);
		$('#del').modal({width:240});
		return false;
	})
</script>