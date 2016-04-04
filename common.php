<?php

date_default_timezone_set('PRC');

error_reporting(E_ALL &~E_NOTICE &~E_DEPRECATED);

include 'ActClass.php';

$db_host = 'localhost';

$db_user = 'caiyy';

$db_pass = 'yangyong1229';

$db_name = 'caiyy';

$xt_name = '某某叉管理系统';

$user_qx = array('777' => '系统管理员' , '666' => '车间管理员' , '555' => '仓库管理员' , '999' => '观察员');

$system_page = 10;

//$user_qxdz = array('系统管理员' => '777' , '车间管理员' => '666' , '仓库管理员' => '555');

$user_info = array();

?>