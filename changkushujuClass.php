<?php
if($user_info['quanxian'] != 777 and $user_info['quanxian'] != 555 and $user_info['ck']==0){
	echo '<h1>您无权执行此操作</h1>';
	exit;
}
$cz = $_GET['cz'];
$user_data = getuser(1);
$ck_ = getcangku();
$ck_data = $ck_['data'];
$cj_data = getchejian();
//var_dump($cj_data);
$dfl_data = getfenlei();
$page = $_GET['page'];
$sjnum = 0;
switch ($cz) {
	case 'get':
		$id = $_GET['id'];
		if($id !=0){
			if($user_info['quanxian'] == 777){
				//$cksj_data = getcangku($id);
				$ck_ = getcangku($id);
				$cksj_data = $ck_['data'];
				$cknum_data = $ck_['flid'];
				$ck_ = getcangku(null,null,$id);
				$ckwz_data = $ck_['data'];
				//$cknum_data = $ck_['cknum'];
				$ck_name = $ck_data[$id]['name'];
			}elseif($user_info['ck'] != 0){
				//$cksj_data = getcangku($user_info['ck']);
				$ck_ = getcangku($user_info['ck']);
				$cksj_data = $ck_['data'];
				$ck_ = getcangku(null,null,$user_info['ck']);
				$ckwz_data = $ck_['data'];
				var_dump($ck_);
				$cknum_data = $ck_['flid'];
				$ck_name = $ck_data[$user_info['ck']]['name'];
			}
		}else{
			$cpmc = $_POST['cpmc'];
			$timein = $_POST['timein'];
			$timeout = $_POST['timeout'];
			$ck_ = qck($cpmc,$timein,$timeout);
			$cksj_data = $ck_['data'];
			$cknum_data = $ck_['flid'];
		}
		break;
	case 'del':
		$url=$_SERVER["HTTP_REFERER"];
		$id = $_POST['id'];
		delcangkushuju($id);
		header("Location:".$url); 
		echo '<meta http-equiv="refresh" content="0;url='.$url.'"> ';
		break;
	case 'set':
		$url=$_SERVER["HTTP_REFERER"];
		if($user_info['quanxian'] != 777){
			$ckid = $user_info['ck'];
		}else{
			$ckid = $_POST['ckid'];
		}
		/*
		$dataid = $_POST['dataid'];
		$ckwz = $_POST['ckwz'];
		$num = $_POST['num'];
		$dfl = $_POST['dfl'];
		$xfl = $_POST['xfl'];
		$cj = $_POST['cj'];
		$gys = $_POST['gys'];
		$userid = $user_info['ID'];
		addcangkushuju($ckid,$ckwz,$num,$dfl,$xfl,$cj,$gys,$userid,$dataid);
		*/
		$data = $_POST;
		$data["userid"] = $user_info['ID'];
		$data["ckid"] = $ckid;
		$dataid = $data['dataid'];
		new_addcksj($ckid,$data,$dataid);
		header("Location:".$url); 
		echo '<meta http-equiv="refresh" content="0;url='.$url.'"> ';
		break;
	case 'add':
		$url=$_SERVER["HTTP_REFERER"];
		//var_dump($url);
		//echo bzadd(0,"shengchan",$_POST);
		if($user_info['quanxian'] != 777){
			$ckid = $user_info['ck'];
		}else{
			$ckid = $_POST['ckid'];
		}
		/*
		$ckwz = $_POST['ckwz'];
		$num = $_POST['num'];
		$dfl = $_POST['dfl'];
		$xfl = $_POST['xfl'];
		$cj = $_POST['cj'];
		$gys = $_POST['gys'];
		$userid = $user_info['ID'];
		addcangkushuju($ckid,$ckwz,$num,$dfl,$xfl,$cj,$gys,$userid);
		*/

		$data = $_POST;
		$data["userid"] = $user_info['ID'];
		$data["ckid"] = $ckid;
		new_addcksj($ckid,$data);
		header("Location:".$url); 
		echo '<meta http-equiv="refresh" content="0;url='.$url.'"> ';
		break;
}
?>
	<div class="am-cf am-padding" style="padding-bottom:0">
		<div class="am-fl am-cf"><a href="admin.php"><strong class="am-text-primary am-text-lg">首页</strong></a> / <small>仓库数据</small>
			<?php
				if($ck_name != ""){
					echo '<span class="am-badge am-badge-success am-radius am-text-sm">'.$ck_name.'</span>';
				}
			?>
		</div>
	</div>
	<div class="am-padding" style="padding-top:0">
		<div class="am-dropdown" data-am-dropdown>
			<button class="am-btn am-btn-primary am-dropdown-toggle am-margin" style="margin-left: 0;margin-right: 0;" id="cxuser" data-am-dropdown-toggle> 选择仓库 <span class="am-icon-caret-down"></span></button>
			<ul class="cxuser am-dropdown-content">
				<?php 
				if($ck_data == null){
					$ck_data[1] = array('name' => '请先添加仓库');
				};
	    	foreach ($ck_data as $vo){
	    	?>
					<li>
						<a href="admin.php?act=changkushuju&cz=get&page=1&id=<?php echo $vo['ID']; ?>" data-num="1">
							<?php echo $vo['name']; ?>
						</a>
					</li>
					<?php
	    	}
	    	?>
			</ul>
		</div>
		<?php
			if($user_info['quanxian']!=999 and $id != null){
		?>
		<button type="button" class="am-btn am-btn-primary am-margin" data-am-modal="{target: '#add', width: 440}">添加仓库数据</button>
		<div class="am-fr">
			<form method="post" class="am-form am-form-inline" action="?act=changkushuju&cz=get&id=0">
				<div class="am-form-group">
					<select name="cpmc" data-am-selected="{searchBox: 1,btnStyle: 'success',maxHeight: 170}">
							<option value="0">请选择产品名称</option>
							<?php
							$allxfl = getallxfl();
							foreach ($allxfl as $dd) {
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
			}
		?>
		<?php
	if($cz=='get'){
	?>		
			<div class="am-scrollable-horizontal">
			<table class="usreinfo am-table am-table-bd am-table-striped am-table-hover admin-content-table am-table-bordered" style="min-width: 950px;">
				<!-- style="display:none;"-->
				<thead>
					<tr>
						<th width="70" align="center">数据ID</th>
						<th>大分类</th>
						<th>小分类</th>
						<th>出入库数量</th>
						<th>库存</th>
						<th>领用人</th>
						<th>来源</th>
						<th>备注</th>
						<th>区域</th>
						<th>操作人</th>
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
					if($cksj_data == null){
						$cksj_data = array();
					};
					foreach ($cksj_data as $vo){
					?>
						<tr data-id = "<?php echo $vo['ID']; ?>" data-ckid = "<?php echo $vo['ckid']; ?>" data-ckwz = "<?php echo $vo['ckwz']; ?>" data-dflid = "<?php echo $vo['dflid']; ?>" data-xflid = "<?php echo $vo['xflid']; ?>" data-num = "<?php echo $vo['num']; ?>" data-cjid = "<?php echo $vo['cjid']; ?>" data-gys = "<?php echo $vo['gys']; ?>" data-userid = "<?php echo $vo['userid']; ?>" data-lx = "<?php echo $vo['lx']; ?>" data-lyr = "<?php echo $vo['lyr']; ?>" data-bz = "<?php echo $vo['bz']; ?>">
							<td><?php echo $vo['ID']; ?></td>
							<td>
								<span class="am-badge am-badge-success am-radius am-text-sm">
								<?php
								echo $dfl_data[$vo['dflid']]['name'];
								?>
								</span>
							</td>
							<td>
								<span class="am-badge am-badge-success am-radius am-text-sm">
								<?php
								$xfl_data = getfenlei($vo['dflid']);
								echo $xfl_data[$vo['xflid']]['name'];
								?>
								</span>
							</td>
							<td>
								<?php
									if($vo['lx']==1){
										echo '<span class="am-badge am-badge-success am-radius am-text-sm">入库 ';
									}elseif($vo['lx']==0){
										echo '<span class="am-badge am-badge-warning am-radius am-text-sm">出库 ';
									}elseif($vo['lx']==2){
										echo '<span class="am-badge am-badge-warning am-radius am-text-sm">预出库 ';
									}
									echo abs($vo['num']);
								?>
								</span>
							</td>
							<td><span class="am-badge am-badge-success am-radius am-text-sm"><?php echo $cknum_data[$vo['dflid']][$vo['xflid']]['cknum']; ?></span></td>
							<td><?php echo $user_data[$vo['lyr']]['name']; ?></td>
							<td>
								<?php
								if($vo['cjid'] == 0){
									echo '来自供应商 [ '.$vo['gys']." ]";
								}else{
									echo $cj_data[$vo['cjid']]['name'];
								}
								?>
							</td>
							<td><?php echo $vo['bz']; ?></td>
							<td><span class="am-badge am-badge-success am-radius am-text-sm"><?php echo $ckwz_data[$vo['ckwz']]['name']; ?></span></td>
							<td>
								<?php
								echo $user_data[$vo['userid']]['name'];
								?>
							</td>
							<td><?php echo date('Y-m-d H:i:s', $vo['time']); ?></td>
							<?php
								if($user_info['quanxian']!=999){
							?>
							<td align="center">
								<div class="am-btn-group">
									<a class="am-btn am-radius am-btn-xs am-btn-warning set" href="#">编辑</a>
									<a class="am-btn am-radius am-btn-xs am-btn-danger del" href="#">删除</a>
								</div>
							</td>
							<?php
								}
							?>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
			</div>
			<ul class="am-pagination">
				<?php
					//echo $sjnum;
					$ysurl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
					$pagenum = $_GET['page'];
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
	</div>
	<?php
		if($user_info['quanxian']!=999){
	?>
		<div class="am-modal am-modal-no-btn" tabindex="-1" id="add">
		<div class="am-modal-dialog">
			<div class="am-modal-hd">测试添加仓库数据
				<a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
			</div>
			<div class="am-modal-bd">
				<form method="post" class="am-form" action="?act=changkushuju&cz=add">
					<div class="am-form-group">
						<label class="am-radio-inline am-warning">
							<input type="radio" name="churuku" value="2" data-am-ucheck checked>
							预出库
						</label>
						<label class="am-radio-inline am-warning">
							<input type="radio" name="churuku" value="0" data-am-ucheck>
							出库
						</label>
						<label class="am-radio-inline am-warning">
							<input type="radio" name="churuku" value="1" data-am-ucheck>
							入库
						</label>
					</div>
					<div class="am-form-group">
						<input name="num" type="text" value="" placeholder="请填写数量"></input>
					</div>
					<div class="am-form-group">
						<label>请选择仓库位置</label>
						<select name="ckwz" id="ckwz" data-am-selected="{searchBox: 1,btnWidth:'220px',btnStyle: 'success',maxHeight: 170}">
							<option value="0">请选择</option>
							<?php
							foreach ($ckwz_data as $dd) {
							?>
								<option value="<?php echo $dd['ID']; ?>">
									<?php echo $dd['name']; ?>
								</option>
								<?php
							}
							?>
						</select>
						<span class="am-form-caret"></span>
					</div>
					<div class="am-form-group">
						<label>请选择大分类</label>
						<select name="dfl" id="dfl1" data-am-selected="{searchBox: 1,btnWidth:'220px',btnStyle: 'success',maxHeight: 170}">
							<option value="0">请选择</option>
							<?php
							foreach ($dfl_data as $dd) {
							?>
								<option value="<?php echo $dd['ID']; ?>">
									<?php echo $dd['name']; ?>
								</option>
								<?php
							}
							?>
						</select>
						<span class="am-form-caret"></span>
					</div>
					<div class="am-form-group">
						<label>请选择小分类</label>
						<select name="xfl" data-am-selected="{searchBox: 1,btnWidth:'220px',btnStyle: 'success',maxHeight: 170}">
							<option value="0">请选择</option>
						</select>
						<span class="am-form-caret"></span>
					</div>
					<div class="am-form-group">
						<label>领用人</label>
						<select name="lyr" data-am-selected="{searchBox: 1,btnWidth:'220px',btnStyle: 'success',maxHeight: 170}">
							<option value="0">请选择</option>
							<?php
							foreach ($user_data as $dd) {
							?>
								<option value="<?php echo $dd['ID']; ?>">
									<?php echo $dd['name']; ?>
								</option>
								<?php
							}
							?>
						</select>
						<span class="am-form-caret"></span>
					</div>
					<div class="am-form-group">
						<input name="bz" type="text" value="" placeholder="备注"></input>
					</div>
					<div class="am-form-group">
						<label style="text-align:center;">请选择车间</label>
					</div>
					<div class="am-form-inline">
						<div class="am-form-group">
							<select name="cj" class="chejian">
								<option value="0">来自供应商</option>
								<?php
								foreach ($cj_data as $dd) {
								?>
									<option value="<?php echo $dd['ID']; ?>">
										<?php echo $dd['name']; ?>
									</option>
								<?php
								}
								?>
							</select>
							<span class="am-form-caret"></span>
							<div style="display:none;">
								<?php
								if($id != null and $user_info['quanxian'] == 777){
								?>
								<input name="ckid" type="text" value="<?php echo $id; ?>"></input>
								<?php
								}
								?>
							</div>
						</div>
						<div class="am-form-group gys">
							<input name="gys" type="text" value="" placeholder="请填写供应商"></input>
						</div>
					</div>
					<button type="submit" class="am-btn am-btn-success am-radius tijiao">提交</button>
				</form>
			</div>
		</div>
	</div>

		<div class="am-modal am-modal-no-btn" tabindex="-1" id="set">
		<div class="am-modal-dialog">
			<div class="am-modal-hd">测试修改仓库数据
				<a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
			</div>
			<div class="am-modal-bd">
				<form method="post" class="am-form" action="?act=changkushuju&cz=set">
					<div class="am-form-group">
						<label class="am-radio-inline am-warning">
							<input type="radio" name="churuku" value="2" data-am-ucheck checked>
							预出库
						</label>
						<label class="am-radio-inline am-warning">
							<input type="radio" name="churuku" value="0" data-am-ucheck>
							出库
						</label>
						<label class="am-radio-inline am-warning">
							<input type="radio" name="churuku" value="1" data-am-ucheck>
							入库
						</label>
					</div>
					<div class="am-form-group">
						<input name="num" type="text" value="" placeholder="请填写数量"></input>
					</div>
					<div class="am-form-group">
						<label>请选择仓库位置</label>
						<select name="ckwz" id="ckwz" data-am-selected="{searchBox: 1,btnWidth:'220px',btnStyle: 'success',maxHeight: 170}">
							<option value="0">请选择</option>
							<?php
							foreach ($ckwz_data as $dd) {
							?>
								<option value="<?php echo $dd['ID']; ?>">
									<?php echo $dd['name']; ?>
								</option>
								<?php
							}
							?>
						</select>
						<span class="am-form-caret"></span>
					</div>
					<div class="am-form-group">
						<label>请选择大分类</label>
						<select name="dfl" id="dfl2" data-am-selected="{searchBox: 1,btnWidth:'220px',btnStyle: 'success',maxHeight: 170}">
							<option value="0">请选择</option>
							<?php
							foreach ($dfl_data as $dd) {
							?>
								<option value="<?php echo $dd['ID']; ?>">
									<?php echo $dd['name']; ?>
								</option>
								<?php
							}
							?>
						</select>
						<span class="am-form-caret"></span>
					</div>
					<div class="am-form-group">
						<label>请选择小分类</label>
						<select name="xfl" data-am-selected="{searchBox: 1,btnWidth:'220px',btnStyle: 'success',maxHeight: 170}">
							<option value="0">请选择</option>
						</select>
						<span class="am-form-caret"></span>
					</div>
					<div class="am-form-group">
						<label>领用人</label>
						<select name="lyr" data-am-selected="{searchBox: 1,btnWidth:'220px',btnStyle: 'success',maxHeight: 170}">
							<option value="0">请选择</option>
							<?php
							foreach ($user_data as $dd) {
							?>
								<option value="<?php echo $dd['ID']; ?>">
									<?php echo $dd['name']; ?>
								</option>
								<?php
							}
							?>
						</select>
						<span class="am-form-caret"></span>
					</div>
					<div class="am-form-group">
						<input name="bz" type="text" value="" placeholder="备注"></input>
					</div>
					<div class="am-form-group">
						<label style="text-align:center;">请选择车间</label>
					</div>
					<input name="dataid" value="" style="display:none;">
					<div class="am-form-inline">
						<div class="am-form-group">
							<select name="cj" class="chejian">
								<option value="0">来自供应商</option>
								<?php
								foreach ($cj_data as $dd) {
								?>
									<option value="<?php echo $dd['ID']; ?>">
										<?php echo $dd['name']; ?>
									</option>
								<?php
								}
								?>
							</select>
							<span class="am-form-caret"></span>
							<div style="display:none;">
								<?php
								if($id != null and $user_info['quanxian'] == 777){
								?>
								<input name="ckid" type="text" value="<?php echo $id; ?>"></input>
								<?php
								}
								?>
							</div>
						</div>
						<div class="am-form-group gys">
							<input name="gys" type="text" value="" placeholder="请填写供应商"></input>
						</div>
					</div>
					<button type="submit" class="am-btn am-btn-success am-radius tijiao">提交</button>
				</form>
			</div>
		</div>
	</div>

<div class="am-modal am-modal-no-btn" tabindex="-1" id="del">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">确定删除仓库数据
      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
    </div>
    <div class="am-modal-bd">
      <form method="post" class="am-form" action="?act=changkushuju&cz=del">
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
var qjxfl;
$('#test').modal({width:440});
$(".chejian").change(function() {
	var id = $(this).find("option:selected").val();
	var gys = $(".gys");
	if(id == 0){
		gys.show();
	}else{
		gys.hide();
	}
});
$(".tijiao").click(function(){
	var churuku,num;
	churuku = $(this).parents(".am-modal").find("*[name=churuku]:checked").val();
	num = $(this).parents(".am-modal").find("*[name=num]").val();
	//var_dump(churuku+"|"+num);
	if(churuku == 0 || churuku == 2){
		$(this).parents(".am-modal").find("*[name=num]").val("-"+num);
	}
})		
$('tbody .set').click(function(){
	var dataid,lx,num,ckwz,dfl,xfl,lyr,bz,cj,gys;
	dataid = $(this).parents("tr").data("id");
	num = $(this).parents("tr").data("num");
	ckwz = $(this).parents("tr").data("ckwz");
	lx = $(this).parents("tr").data("lx");
	dfl = $(this).parents("tr").data("dflid");
	xfl = $(this).parents("tr").data("xflid");
	qjxfl = xfl;
	lyr = $(this).parents("tr").data("lyr");
	cj = $(this).parents("tr").data("cjid");
	gys = $(this).parents("tr").data("gys");
	bz = $(this).parents("tr").data("bz");
	$('#set *[name=ckwz] option[value='+ckwz+']').attr('selected', true);
	$('#set *[name=churuku][value='+lx+']').uCheck('check');
	$("#set *[name=dataid]").val(dataid);
	$("#set *[name=num]").val(Math.abs(num));
	$("#set *[name=dfl]").val(dfl);
	$('#set *[name=dfl] option[value='+dfl+']').attr('selected', true);
	$("#set *[name=xfl]").html('<option>正在获取数据.</option>');
	$.get("ajax.php?cz=xfldq&caiyy=ck&id=" + dfl, function(data) {
		$("#set *[name=xfl]").html(data).val(xfl);
	})
	$("#set *[name=lyr]").val(lyr);
	$('#set *[name=lyr] option[value='+lyr+']').attr('selected', true);
	$("#set *[name=cj]").val(cj);
	if(cj == 0 ){
		$("#set *[name=gys]").val(gys).parents(".gys").show();
		//$("#set *[name=gys]").val(gys).show();
	}else{
		//$("#set *[name=gys]").hide();
		$("#set *[name=gys]").val("").parents(".gys").hide();
	}
	$("#set *[name=bz]").val(bz);
	$('#set').modal({width:440});
	return false;
})
$("#dfl1").change(function() {
	var xfl1 = $("#add *[name=xfl]");
	xfl1.html('<option>正在获取数据.</option>');
	var id = $("#dfl1 option:selected").val();
	if (id != 0) {
		$.get("ajax.php?cz=xfldq&caiyy=ck&id=" + id, function(data) {
			xfl1.html(data).find("");
		})
	}
});
$("#dfl2").change(function() {
	var xfl1 = $("#set *[name=xfl]");
	xfl1.html('<option>正在获取数据.</option>');
	var id = $("#dfl2 option:selected").val();
	if (id != 0) {
		$.get("ajax.php?cz=xfldq&caiyy=ck&id=" + id, function(data) {
			xfl1.html(data).val(qjxfl);
		})
	}
});
$('tbody .del').click(function(){
	var id,name,html;
	//id = $(this).parents("tr").find("td:eq(0)").data("u");
	id = $(this).parents("tr").data("id");
	html = "数据ID:"+id+"<br/>";
	$("#del .id").attr("value",id);
	$("#del .tips-text").html(html);
	$('#del').modal({width:240});
	return false;
})
</script>