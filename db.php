<?php
function condb(){
	Global $db_host,$db_user,$db_pass,$db_name;
	$link = mysql_connect($db_host,$db_user,$db_pass);
	if (!$link) {
	    die('连接数据库失败,错误信息: ' . mysql_error());
	}else{
		if (!mysql_select_db($db_name, $link)){ //跳转到 think_caiyy 数据库
			die('跳转数据库失败失败,错误信息: ' . mysql_error());
		}else{
			return 1;
		}
	}
}
?>