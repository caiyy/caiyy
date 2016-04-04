<?php
if($user_info['quanxian'] != 777 and $user_info['quanxian'] != 666 and $user_info['cj']==0){
	echo '<h1>您无权执行此操作</h1>';
	exit;
}
$cz = $_GET['cz'];
$user_data = getuser(1);
$cj_data = getchejian();
//$dfl_data = getfenlei();
$xfl_data = getfenlei(999999);
$page = $_GET['page'];
$sjnum = 0;
switch ($cz) {
	case 'get':
		$id = $_GET['id'];
		if($id != 0){
			if($user_info['quanxian'] == 777){
				$cjsj_data = getchejian($id);
				$cj_name = $cj_data[$id]['name'];
			}elseif($user_info['cj'] != 0){
				//$cjsj_data = getchejian($user_info['cj'],$user_info['ID']);
				$cjsj_data = getchejian($user_info['cj']);
				$cj_name = $cj_data[$user_info['cj']]['name'];
				//var_dump($user_info);
			}
		}else{
			$cpmc = $_POST['cpmc'];
			$timein = $_POST['timein'];
			$timeout = $_POST['timeout'];
			$temp = qcj($cpmc,$timein,$timeout);
			$numdata = $temp['numdata'];
			$cjsj_data = $temp['data'];
		}
		break;
	case 'del':
		$url=$_SERVER["HTTP_REFERER"];
		//var_dump($url);
		$id = $_POST['id'];
		delshengchan($id);
		header("Location:".$url); 
		echo '<meta http-equiv="refresh" content="0;url='.$url.'"> ';
		break;
	case 'set':
		$url=$_SERVER["HTTP_REFERER"];
		//var_dump($url);
		if($user_info['quanxian'] != 777){
			$cjid = $user_info['cj'];
		}else{
			$cjid = $_POST['cjid'];
		}
		$dataid = $_POST['dataid'];
		$num = $_POST['num'];
		$dfl = $_POST['dfl'];
		$xfl = $_POST['xfl'];
		$data['num'] = $_POST['num'];
		$data['cpnum'] = $_POST['cpnum'];
		$data['kcnum'] = $_POST['kcnum'];
		$userid = $user_info['ID'];
		addshengchan($cjid,$dfl,$xfl,$xflname,$data,$userid,$dataid);
		header("Location:".$url); 
		echo '<meta http-equiv="refresh" content="0;url='.$url.'"> ';
		break;
	case 'add':
		$url=$_SERVER["HTTP_REFERER"];
		//var_dump($url);
		if($user_info['quanxian'] != 777){
			$cjid = $user_info['cj'];
		}else{
			$cjid = $_POST['cjid'];
		}
		$num = $_POST['num'];
		$data['num'] = $_POST['num'];
		$data['cpnum'] = $_POST['cpnum'];
		$data['kcnum'] = $_POST['kcnum'];
		$dfl = $_POST['dfl'];
		$xfl = $_POST['xfl'];
		$userid = $user_info['ID'];
    //var_dump($_POST);
    //$cjid,$dflid,$xflid,$num,$userid
		$xflname = $_POST['xflname'];
		addshengchan($cjid,$dfl,$xfl,$xflname,$data,$userid);
		header("Location:".$url);
		echo '<meta http-equiv="refresh" content="0;url='.$url.'"> ';
		break;
}
?>


	<div class="am-cf am-padding" style="padding-bottom:0">
		<div class="am-fl am-cf"><a href="admin.php"><strong class="am-text-primary am-text-lg">首页</strong></a> / <small>车间数据</small>
			<?php
				if($cj_name != ""){
					echo '<span class="am-badge am-badge-success am-radius am-text-sm">'.$cj_name.'</span>';
				}
			?>
		</div>
	</div>
	<div class="am-padding" style="padding-top:0">



		<div class="am-dropdown" data-am-dropdown>
			<button class="am-btn am-btn-primary am-dropdown-toggle am-margin" style="margin-left: 0;margin-right: 0;" id="cxuser" data-am-dropdown-toggle> 选择车间 <span class="am-icon-caret-down"></span></button>
			<ul class="cxuser am-dropdown-content">
				<?php  
				if($cj_data == null){
					$cj_data[] = array('name'=>'暂无数据,请添加数据');
				};
	    	foreach ($cj_data as $vo){
	    	?>
					<li>
						<a href="admin.php?act=chejianshuju&cz=get&page=1&id=<?php echo $vo['ID']; ?>" data-num="1">
							<?php echo $vo['name']; ?>
						</a>
					</li>
					<?php
	    	}
	    	?>
			</ul>
		</div>
<?php
/*
$time = time_yue();
echo $time['in'],"|",$time['out'],'<br/>';
echo date("Y-m-d H:i:s",$time['in']),"|",date("Y-m-d H:i:s",$time['out']),'<br/>';
*/
/*
	1	ID	int(11)	否	无	AUTO_INCREMENT	 修改 修改	 删除 删除	更多 显示更多操作
	2	cjid	int(11)			是	NULL		 修改 修改	 删除 删除	更多 显示更多操作
	3	dflid	int(11)			是	NULL		 修改 修改	 删除 删除	更多 显示更多操作
	4	xflid	int(11)			是	NULL		 修改 修改	 删除 删除	更多 显示更多操作
	5	num	int(11)				是	NULL		 修改 修改	 删除 删除	更多 显示更多操作
	6	userid	int(11)		是	NULL		 修改 修改	 删除 删除	更多 显示更多操作
	7	time	int(11)			是	NULL		 修改 修改	 删除 删除	更多 显示更多操作
*/
?>
		
		<?php
			if($user_info['quanxian']!=999 and $id != null){
		?>
		<button type="button" class="am-btn am-btn-primary am-margin" data-am-modal="{target: '#add', width: 240}">添加车间数据</button>
		<?php
			}
		?>
		<div class="am-fr">
			<form method="post" class="am-form am-form-inline" action="?act=chejianshuju&cz=get&id=0">
				<div class="am-form-group">
					<select name="cpmc" data-am-selected="{searchBox: 1,btnStyle: 'success',maxHeight: 170}">
							<option value="0">请选择产品名称</option>
							<?php
							foreach ($xfl_data as $dd) {
							?>
								<option value="<?php echo $dd['ID']; ?>">
									<?php echo $dd['name']; ?>
								</option>
							<?php
							}
							?>
					</select>
				</div>
				<div class="am-form-group">
					<input name="timein" style="width:100px;" type="text" class="am-form-field" placeholder="<?php echo date('Y-m-d', mktime(0,0,0,date('m'),1,date('Y'))); ?>" data-am-datepicker readonly/>
				</div>
				<div class="am-form-group">
					<input name="timeout" style="width:100px;" type="text" class="am-form-field" placeholder="<?php echo date('Y-m-d', mktime(23,59,59,date('m'),date('t'),date('Y'))); ?>" data-am-datepicker readonly/>
				</div>
				<button style="margin-left: 0;margin-right: 0;" type="submit" class="am-btn am-btn-primary am-margin">搜索</button>
			</form>
		</div>
		<?php
	if($cz=='get'){
	?>
			<table class="usreinfo am-table am-table-bd am-table-striped am-table-hover admin-content-table am-table-bordered">
				<!-- style="display:none;"-->
				<thead>
					<tr>
						<th width="70" align="center">数据ID</th>
						<th>产品名称</th>
						<th>领用数量</th>
						<th>成品数量</th>
						<th>库存数量</th>
						<th>操作用户</th>
						<th width="180" align="center">操作时间</th>
						<?php
							if($user_info['quanxian']!=999){
						?>
						<th width="150" align="center">管理</th>
						<?php
							}
						?>
					</tr>
				</thead>
				<tbody>
					<?php  
					if($cjsj_data == null){
						$cjsj_data = array();
					};
					foreach ($cjsj_data as $vo){
					?>
						<tr data-u="<?php echo $vo['ID']; ?>" data-qx="<?php echo $vo['quanxian'] ?>">
							<td data-u="<?php echo $vo['ID']; ?>"><?php echo $vo['ID']; ?></td>
							<td data-d="<?php echo $vo['dflid']; ?>" data-x="<?php echo $vo['xflid']; ?>">
								<span class="am-badge am-badge-success am-radius am-text-sm">
								<?php
								echo $xfl_data[$vo['xflid']]['name'];
								?>
								</span>
							</td>
							<td data-u="<?php echo $vo['num']; ?>">
								<span class="am-badge am-badge-secondary am-radius am-text-sm">
									<?php echo $vo['num']; ?>
								</span>
							</td>
							<td data-u="<?php echo $vo['cpnum']; ?>">
								<span class="am-badge am-badge-success am-radius am-text-sm">
									<?php echo $vo['cpnum']; ?>
								</span>
							</td>
							<td data-u="<?php echo $vo['kcnum']; ?>">
								<span class="am-badge am-badge-primary am-radius am-text-sm">
									<?php echo $vo['kcnum']; ?>
								</span>
							</td>
							<td data-u="<?php echo $vo['user']; ?>">
								<?php echo $user_data[$vo['userid']]['name']; ?>
							</td>
							<td align="center" data-u="<?php echo $vo['time']; ?>"><?php echo date('Y-m-d H:i:s', $vo['time']); ?></td>
							<?php
								if($user_info['quanxian']!=999){
							?>
							<?php
								}
							?>
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
			<ul class="am-pagination">
				<?php
					//echo $sjnum;
					$ysurl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
					$pagenum = $_GET['page'];
					//echo $sjnum,"|";
					if($pagenum<1){
						$pagenum = 1;
					}
					$zpage = $sjnum/$system_page;
					for ($x=0; $x<=$zpage; $x++) {
						$pagexx = $x+1;
						$pageurl = str_replace('&page='.$pagenum,'&page='.$pagexx,$ysurl);
						echo '<li';
						if($pagenum == $pagexx){
							echo  ' class="am-active"';
						}
						echo '><a href="'.$pageurl.'">'.$pagexx.'</a></li>';
						//echo $pageurl,"<br/>";
					} 
				?>
			</ul>
			<?php
			}
			?>
			<?php
				if($id === '0'){
			?>
			<span class="am-badge am-badge-secondary am-radius am-text-lg">领用数量统计:<?php echo $numdata['num']; ?></span>
			<span class="am-badge am-badge-success am-radius am-text-lg">成品数量统计:<?php echo $numdata['cpnum']; ?></span>
			<span class="am-badge am-badge-primary am-radius am-text-lg">库存数量统计:<?php echo $numdata['kcnum']; ?></span>
			<?php
				}
			?>
			
	</div>



	<?php
		if($user_info['quanxian']!=999){
	?>
	<div class="am-modal am-modal-no-btn" tabindex="-1" id="add">
		<div class="am-modal-dialog">
			<div class="am-modal-hd">添加车间数据
				<a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
			</div>
			<div class="am-modal-bd">
				<form method="post" class="am-form" action="?act=chejianshuju&cz=add">
					<div class="am-form-group">
						<input name="num" type="text" value="" placeholder="请输入出领用数量"></input>
					</div>
					<div class="am-form-group">
						<input name="cpnum" type="text" value="" placeholder="请输入成品数量"></input>
					</div>
					<div class="am-form-group">
						<input name="kcnum" type="text" value="" placeholder="请输入库存数量"></input>
					</div>
					<div class="am-form-group">
						<label>请选择产品名称</label>
						<select name="xfl" data-am-selected="{searchBox: 1,btnWidth:'220px',btnStyle: 'success',maxHeight: 170}">
							<option value="0">自定义</option>
							<?php
							foreach ($xfl_data as $dda) {
							?>
							<option value="<?php echo $dda['ID']; ?>"><?php echo $dda['name']; ?> </option>
							<?php
							}
							?>
						</select>
						<!--select name="xfl">
							<option value="0">请选择</option>
						</select-->
						<span class="am-form-caret"></span>
					</div>
					<div class="am-form-group">
						<input name="xflname" type="text" value="" placeholder="请输入名称"></input>
					</div>
					<div class="am-form-group">
						<div style="display:none;">
							<input name="dfl" type="text" value="999999"></input>
							<?php
							if($id != null and $user_info['quanxian'] == 777){
							?>
							<input name="cjid" type="text" value="<?php echo $id; ?>"></input>
							<?php
							}
							?>
						</div>
					</div>
					<button type="submit" class="am-btn am-btn-success am-radius">提交</button>
				</form>
			</div>
		</div>
	</div>

  <div class="am-modal am-modal-no-btn" tabindex="-1" id="set">
		<div class="am-modal-dialog">
			<div class="am-modal-hd">修改车间数据
				<a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
			</div>
			<div class="am-modal-bd">
				<form method="post" class="am-form" action="?act=chejianshuju&cz=set">
					<div class="am-form-group">
						<input name="num" type="text" value="" placeholder="请输入出领用数量"></input>
					</div>
					<div class="am-form-group">
						<input name="cpnum" type="text" value="" placeholder="请输入成品数量"></input>
					</div>
					<div class="am-form-group">
						<input name="kcnum" type="text" value="" placeholder="请输入库存数量"></input>
					</div>
					<div class="am-form-group">
						<label>请选择产品名称</label>
						<select name="xfl" data-am-selected="{searchBox: 1,btnWidth:'220px',btnStyle: 'success',maxHeight: 170}">
							<option value="0">自定义</option>
							<?php
							foreach ($xfl_data as $dda) {
							?>
							<option value="<?php echo $dda['ID']; ?>"><?php echo $dda['name']; ?> </option>
							<?php
							}
							?>
						</select>
						<span class="am-form-caret"></span>
					</div>
					<div class="am-form-group">
						<input name="xflname" type="text" value="" placeholder="请输入名称"></input>
					</div>
					<div class="am-form-group">
						<div style="display:none;">
							<input name="dfl" type="text" value="999999"></input>
							<?php
							if($id != null and $user_info['quanxian'] == 777){
							?>
							<input name="cjid" type="text" value="<?php echo $id; ?>"></input>
							<?php
							}
							?>
              <input name="dataid" type="text" value=""></input>
						</div>
					</div>
					<button type="submit" class="am-btn am-btn-success am-radius">提交</button>
				</form>
			</div>
		</div>
	</div>
	<div class="am-modal am-modal-no-btn" tabindex="-1" id="del">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">确定删除生产数据
      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
    </div>
    <div class="am-modal-bd">
      <form method="post" class="am-form" action="?act=chejianshuju&cz=del">
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
	<?php
		}
	?>



<script>
$("#add *[name=xfl]").change(function(){
	var id = $("#add *[name=xfl] option:selected").val();
	if(id == 0){
		$("#add *[name=xflname]").show();
	}else{
		$("#add *[name=xflname]").hide();
	}
});

$("#set *[name=xfl]").change(function(){
	var id = $("#set *[name=xfl] option:selected").val();
	if(id == 0){
		$("#set *[name=xflname]").show();
	}else{
		$("#set *[name=xflname]").hide();
	}
});
	
$('tbody .set').click(function(){
	var dataid,num,dfl,xfl,cj,cpnum,kcnum;
	dataid = $(this).parents("tr").find("td:eq(0)").data("u");
	num = $(this).parents("tr").find("td:eq(2)").data("u");
	cpnum = $(this).parents("tr").find("td:eq(3)").data("u");
	kcnum = $(this).parents("tr").find("td:eq(4)").data("u");
	//dfl = $(this).parents("tr").find("td:eq(1)").data("d");
	xfl = $(this).parents("tr").find("td:eq(1)").data("x");
	cj = $(this).parents("tr").find("td:eq(5)").data("u");
	//var_dump(id+"|"+name+"|"+quanxian+"|"+ck+"|"+cj);
	$("#set *[name=dataid]").val(dataid);
	$("#set *[name=num]").val(num);
	$("#set *[name=cpnum]").val(cpnum);
	$("#set *[name=kcnum]").val(kcnum);
	//$("#set *[name=dfl]").val(dfl);
	//$('#set *[name=dfl] option[value='+dfl+']').attr('selected', true);
	//$("#set *[name=xfl]").val(xfl);
	$('#set *[name=xfl]').find('option[value='+xfl+']').attr('selected', true);
	//var_dump(xfl);
	$("#set *[name=cj]").val(cj);
	$('#set').modal({width:240});
	return false;
})

$('tbody .del').click(function(){
	var id,num;
	id = $(this).parents("tr").find("td:eq(0)").data("u");
  num = $(this).parents("tr").find("td:eq(2)").data("u");
	html = "数据ID:"+id+"<br/>";
  html += "生产数量:"+num+"<br/>";
	$("#del .id").attr("value",id);
	$("#del .tips-text").html(html);
	$('#del').modal({width:240});
	return false;
})
</script>