<?php
//echo '<h1>功能开发中,敬请期待.</h1>';
//exit;
if($juri != 777){
	echo '<h1>您无权执行此操作</h1>';
	exit;
}elseif($juri == 777){
	$user_data = getuser(1);
	$hsz_list = array(
								'dafenlei'=>array('page'=>'dafenlei','name'=>'大分类','caiyy'=>array('ID','name')),
								'xiaofenlei'=>array('page'=>'xiaofenlei','name'=>'子分类','caiyy'=>array('ID','name')),
								'cangku'=>array('page'=>'cangku','name'=>'仓库','caiyy'=>array('ID','name')),
								'cangkushuju'=>array('page'=>'cangkushuju','name'=>'仓库数据','caiyy'=>array('ID','ckname','xflname','num','cjname')),
								'chejian'=>array('page'=>'chejian','name'=>'车间','caiyy'=>array('ID','name')),
								'shengchan'=>array('page'=>'shengchan','name'=>'车间数据','caiyy'=>array('ID','cjname','xflname','num','cpnum','kcnum'))
							);
	//var_dump(count($hsz_list[0]['caiyy']));
	$cz = $_GET['cz'];
	if($cz == 'get'){
		$page = $_GET['pages'];
		if($page!=''){
			$del_data = getdel($page);
		}
		switch ($page){
			case 'dafenlei':
				$page_name = "大分类回收站";
				$table_top = array('分类ID','分类名称','执行用户','执行时间');
				break;
			case 'xiaofenlei':
				$page_name = "子分类回收站";
				$table_top = array('分类ID','分类名称','执行用户','执行时间');
				break;
			case 'cangku':
				$page_name = "仓库回收站";
				$table_top = array('仓库ID','仓库名称','执行用户','执行时间');
				break;
			case 'cangkushuju':
				$cj_data = getchejian();
				$ck_ = getcangku();
				$ck_data = $ck_['data'];
				$xfl_data = getfenlei(999999);
				foreach ($del_data as $vo){
					$vo['ckname']=$ck_data[$vo['ckid']]['name'];
					$vo['cjname']=$cj_data[$vo['cjid']]['name'];
					$vo['xflname']=$xfl_data[$vo['xflid']]['name'];
					$del_data[$vo['ID']] = $vo;
				}
				$page_name = "仓库数据回收站";
				$table_top = array('数据ID','所属仓库','分类名称','数量','来源','执行用户','执行时间');
				break;
			case 'chejian':
				$page_name = "车间回收站";
				$table_top = array('车间ID','车间名称','执行用户','执行时间');
				break;
			case 'shengchan':
				$cj_data = getchejian();
				$xfl_data = getfenlei(999999);
				foreach ($del_data as $vo){
					$vo['cjname']=$cj_data[$vo['cjid']]['name'];
					$vo['xflname']=$xfl_data[$vo['xflid']]['name'];
					$del_data[$vo['ID']] = $vo;
				}
				$page_name = "车间数据回收站";
				$table_top = array('数据ID','所属车间','分类名称','领用数量','成品数量','库存数量','执行用户','执行时间');
				break;
		}
	}elseif($cz == 'del'){
		$page = $_GET['pages'];
		$url=$_SERVER["HTTP_REFERER"];
		$dataid = $_POST['dataid'];
		deldel($page,$dataid);
		header("Location:".$url); 
		echo '<meta http-equiv="refresh" content="0;url='.$url.'"> ';
	}elseif($cz == 're'){
		$page = $_GET['pages'];
		$url=$_SERVER["HTTP_REFERER"];
		$dataid = $_POST['dataid'];
		hfdel($page,$dataid);
		header("Location:".$url);
		echo '<meta http-equiv="refresh" content="0;url='.$url.'"> ';
	}
	//echo 'caiyy';
}

?>
<div class="am-cf am-padding" style="padding-bottom:0">
	<div class="am-fl am-cf"><a href="admin.php"><strong class="am-text-primary am-text-lg">首页</strong></a> / <small>数据回收站</small>
		<?php if($page != null){ echo '<span class="am-badge am-badge-success am-radius am-text-sm">'.$page_name.'</span>'; } ?>
	</div>
</div>
<div class="am-padding" style="padding-top:0">
	<div class="am-dropdown" data-am-dropdown>
		<button class="am-btn am-btn-primary am-dropdown-toggle am-margin" style="margin-left: 0;margin-right: 0;" id="cxuser" data-am-dropdown-toggle> 选择回收站 <span class="am-icon-caret-down"></span></button>
		<ul class="cxuser am-dropdown-content">
			<?php
			foreach ($hsz_list as $vo){
			?>
				<li>
					<a href="admin.php?act=huishouzhan&cz=get&pages=<?php echo $vo['page']; ?>" data-num="1">
						<?php echo $vo['name'].'<div style="float: right;">回收站</div>'; //  echo $vo['caiyy'][0]; echo $vo['caiyy'][1]; ?>
					</a>
				</li>
			<?php
			}
			?>
		</ul>
	</div>
	<?php
	if($page != null){
	?>
	<table class="usreinfo am-table am-table-bd am-table-striped am-table-hover admin-content-table am-table-bordered"><!-- style="display:none;"-->
		<thead>
	        <tr>
							<?php
								$i = 0;
								foreach($table_top as $vl){
									$i=$i+1;
							?>
							<th <?php if($i == 1){ echo 'width="70"'; } ?> align="center"><?php echo $vl; ?></th>
							<?
								}
							?>
	           <th width="180" align="center">管理</th>
	       </tr>
	  </thead>
	  <tbody>
	  <?php
		//var_dump($del_data);
		//var_dump(count($hsz_list[$page]['caiyy']));
		if($del_data == null){
			$del_data[] = array('name' => '暂无数据');
		};
	  foreach ($del_data as $vo){
			
	  ?>
		<tr data-u="<?php echo $vo['ID']; ?>" data-qx="<?php echo $vo['quanxian'] ?>">
			<?php
			foreach($hsz_list[$page]['caiyy'] as $hsz_vo){
			?>
			<td data-u="<?php echo $vo[$hsz_vo]; ?>"><?php echo $vo[$hsz_vo]; ?></td>
			<?php
				if($vo['deluser']==0){
					$deluser = "管理员";
				}elseif($vo['deluser']<1){
					$deluser = "未知用户";
				}elseif($vo['deluser']>0){
					$deluser = $user_data[$vo['deluser']]['name'];
				}
			}
			?>
			<td data-u="<?php echo $vo['deluser']; ?>"><?php echo $deluser; ?></td>
			<?php
				$vo_time = $vo['deltime'];
				if($vo_time>0){
					$deltime = date('Y-m-d H:i:s', $vo_time);
				}elseif($vo_time<1){
					$deltime = "未知时间";
				}
			?>
			<td data-u="<?php echo $deltime; ?>"><?php echo $deltime; ?></td>
			<td align="center">
				<div class="am-btn-group">
					<?php
					if($vo['name'] != '暂无数据'){
					?>
					<a class="am-btn am-radius am-btn-xs am-btn-warning set" data-id="<?php echo $vo['ID']; ?>" href="#">恢复数据</a>
					<a class="am-btn am-radius am-btn-xs am-btn-danger del" data-id="<?php echo $vo['ID']; ?>" href="#">彻底删除</a>
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
	<?php
	}
	?>
</div>
<div class="am-modal am-modal-no-btn" tabindex="-1" id="del">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">确定彻底删除数据?
      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
    </div>
    <div class="am-modal-bd">
      <form method="post" class="am-form" action="?act=huishouzhan&pages=<?php echo $page; ?>&cz=del">
      	<div class="am-form-group" style="display:none;">
      		<input class="dataid" name="dataid" type="text"></input>
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
<div class="am-modal am-modal-no-btn" tabindex="-1" id="set">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">确定恢复数据?
      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
    </div>
    <div class="am-modal-bd">
      <form method="post" class="am-form" action="?act=huishouzhan&pages=<?php echo $page; ?>&cz=re">
      	<div class="am-form-group" style="display:none;">
      		<input class="dataid" name="dataid" type="text"></input>
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
$("table .set").click(function(){
	var dataid = $(this).parents("tr").find("td:eq(0)").data("u");
	$("#set .dataid").attr("value",dataid);
	$('#set').modal({width:240});
	return false;
})
$("table .del").click(function(){
	var dataid = $(this).parents("tr").find("td:eq(0)").data("u");
	$("#del .dataid").attr("value",dataid);
	$('#del').modal({width:240});
	return false;
})
</script>
