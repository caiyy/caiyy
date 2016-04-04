<?php

$user = $_COOKIE["name"];
$pass = $_COOKIE["pass"];
$re = yzuser($user,$pass);
$act = $_GET["act"];
if($re != "success"){
  header("location:index.php");
}
?>
<!doctype html>
<html class="no-js fixed-layout">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $xt_name ?>-后台管理</title>
  <meta name="description" content="<?php echo $xt_name ?>">
  <meta name="keywords" content="index">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="icon" type="image/png" href="assets/i/favicon.png">
  <link rel="apple-touch-icon-precomposed" href="assets/i/app-icon72x72@2x.png">
  <meta name="apple-mobile-web-app-title" content="Caiyy[仓管]" />
  <link rel="stylesheet" href="assets/css/amazeui.min.css"/>
  <link rel="stylesheet" href="assets/css/admin.css">
  <link rel="stylesheet" href="css/jquery.bigautocomplete.css" type="text/css" /> 
  <script src="js/caiyy.js"></script>
  <!--[if lt IE 9]>
  <script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
  <script src="assets/js/amazeui.ie8polyfill.min.js"></script>
  <![endif]-->
  <!--[if (gte IE 9)|!(IE)]><!-->
	<script src="assets/js/jquery.min.js"></script>
  <!--<![endif]-->
	<script src="assets/js/amazeui.min.js"></script>
	<script src="assets/js/app.js"></script>
	<script type="text/javascript" src="js/jquery.bigautocomplete.js"></script>
	<script type="text/javascript">
		window.onbeforeunload = onbeforeunload_handler;
		function onbeforeunload_handler() {
		    $.AMUI.progress.start();
		};
	</script>
</head>
<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，<?php echo $xt_name ?> 暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
  以获得更好的体验！</p>
<![endif]-->
<header class="am-topbar admin-header">
  <div class="am-topbar-brand">
	  <a href="admin.php" class="am-text-ir" data-am-popover="{content: '返回 <?php echo $xt_name ?> 首页', trigger: 'hover focus'}"><strong><?php echo $xt_name ?></strong> <small>后台管理</small></a>
  </div>
  <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>
  <div class="am-collapse am-topbar-collapse" id="topbar-collapse">
    <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
      <li class="am-dropdown" data-am-dropdown>
        <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
          <span class="am-icon-users"></span> <?php echo $user_qx[$user_info['quanxian']] ?> <?php echo $user_info['name'] ?> <span class="am-icon-caret-down"></span>
        </a>
        <ul class="am-dropdown-content">
          <li><a href="index.php?act=logout"><span class="am-icon-power-off"></span> 退出</a></li>
        </ul>
      </li>
      <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
    </ul>
  </div>
</header>
<div class="am-cf admin-main">
  <!-- sidebar start -->
  <div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
    <div class="am-offcanvas-bar admin-offcanvas-bar">
      <ul class="am-list admin-sidebar-list">
        <li name="active" <?php if($act=="index" or $act==""){ echo 'class="caiyy-active"'; } ?> ><a href="admin.php"><span class="am-icon-home"></span> 首页</a></li>
        <li class="admin-parent">
          <a class="am-cf" <?php //data-am-collapse="{target: '#collapse-nav'}"?>><span class="am-icon-file"></span> 管理模块 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
          <ul class="am-list am-collapse admin-sidebar-sub am-in" id="collapse-nav">
            <?php $juri = $user_info['quanxian']; ?>
            <?php if($juri == 777 || $juri == 555 ){ ?>
              <li name="active" <?php if($act=="fenlei"){ echo 'class="caiyy-active"'; } ?> ><a href="?act=fenlei" class="am-cf"><span class="am-icon-bars"></span> 分类管理</a></li>
            <?php  } ?>
            <?php if($juri == 777){ ?>
              <li name="active"  <?php if($act=="changku"){ echo 'class="caiyy-active"'; } ?> ><a href="?act=changku" class="am-cf"><span class="am-icon-institution"></span> 仓库管理</a></li>
            <?php  } ?>
            <?php if($juri == 777 || $juri == 555  || $user_info['ck'] != 0 ){ ?>
              <li name="active"  <?php if($act=="changkushuju"){ echo 'class="caiyy-active"'; } ?> ><a href="?act=changkushuju" class="am-cf"><span class="am-icon-institution"></span> 仓库数据</a></li>
            <?php  } ?>
            <?php if($juri == 777 ){ ?>
              <li name="active"  <?php if($act=="chejian"){ echo 'class="caiyy-active"'; } ?> ><a href="?act=chejian"><span class="am-icon-cogs"></span> 车间管理</a></li>
            <?php  } ?>
            <?php if($juri == 777 || $juri == 666 || $user_info['cj'] != 0 ){ ?>
              <li name="active"  <?php if($act=="chejianshuju"){ echo 'class="caiyy-active"'; } ?> ><a href="?act=chejianshuju"><span class="am-icon-cogs"></span> 车间数据</a></li>
            <?php  } ?>
            <?php if($juri == 777){ ?>
			  <li name="active"  <?php if($act=="huishouzhan"){ echo 'class="caiyy-active"'; } ?> ><a href="?act=huishouzhan"><span class="am-icon-xing"></span> 数据回收站</a></li>
              <li name="active" <?php if($act=="user"){ echo 'class="caiyy-active"'; } ?> ><a href="?act=user"><span class="am-icon-group"></span> 用户管理</a></li>
            <?php  } ?>
          </ul>
        </li>
<?php
if($juri == 777){
	/*
          <li><a href="admin-sc.php"><span class="am-icon-pie-chart"></span> 生产量查询</a></li>
	*/
}
?>
        <li name="active"><a href="index.php?act=logout"><span class="am-icon-sign-out"></span> 注销</a></li>
      </ul>
      <div class="am-panel am-panel-default admin-sidebar-panel">
<?php
$my_intro = '
        <div class="am-panel-bd">
          <p><span class="am-icon-tag"></span> 信息</p>
          <p> 本 系 统 由 <a target="_blank" href="http://www.caiyy.cn/">Caiyy</a> 提 供 技 术 支 持 !</p>
        </div>
';
echo base64_decode("
ICAgICAgICA8ZGl2IGNsYXNzPSJhbS1wYW5lbC1iZCI+CiAgICAgICAgICA8cD48c3BhbiBjbGFzcz0iYW0taWNvbi10YWciPjwvc3Bhbj4g5L+h5oGvPC9wPgogICAgICAgICAgPHA+IOacrCDns7sg57ufIOeUsSA8YSB0YXJnZXQ9Il9ibGFuayIgaHJlZj0iaHR0cDovL3d3dy5jYWl5eS5jbi8iPkNhaXl5PC9hPiDmj5Ag5L6bIOaKgCDmnK8g5pSvIOaMgSAhPC9wPgogICAgICAgIDwvZGl2Pg==
      ");

?>
      </div>
    </div>
  </div>
  <!-- sidebar end -->
  <!-- content start -->
  <div class="admin-content">