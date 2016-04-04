<meta content='text/html; charset=utf-8' http-equiv='Content-Type'>
<?php include('common.php'); ?>
<?php
mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($db_name);
//$sql = "ALTER TABLE  `shengchan` ADD  `cpnum` INT DEFAULT '0' NULL AFTER  `num` , ADD  `kcnum` INT DEFAULT '0' NULL AFTER  `cpnum`;"
$sql = "
ALTER TABLE `dafenlei` ADD  `deluser` INT;
ALTER TABLE `chejian` ADD  `deluser` INT;
ALTER TABLE `xiaofenlei` ADD  `deluser` INT;
ALTER TABLE `cangku` ADD  `deluser` INT;
ALTER TABLE `cangkushuju` ADD  `deluser` INT;
ALTER TABLE `shengchan` ADD  `deluser` INT;
ALTER TABLE `dafenlei` ADD  `deltime` INT;
ALTER TABLE `chejian` ADD  `deltime` INT;
ALTER TABLE `xiaofenlei` ADD  `deltime` INT;
ALTER TABLE `cangku` ADD  `deltime` INT;
ALTER TABLE `cangkushuju` ADD  `deltime` INT;
ALTER TABLE `shengchan` ADD  `deltime` INT;
ALTER TABLE `dafenlei` ADD  `del` int DEFAULT '0';
ALTER TABLE `chejian` ADD  `del` int DEFAULT '0';
ALTER TABLE `xiaofenlei` ADD  `del` int DEFAULT '0';
ALTER TABLE `cangku` ADD  `del` int DEFAULT '0';
ALTER TABLE `cangkushuju` ADD  `del` int DEFAULT '0';
ALTER TABLE `shengchan` ADD  `del` int DEFAULT '0';
";
$query_e = explode(';',$sql);
foreach ($query_e as $k =>$v)
{
	mysql_query($query_e[$k]);
}
mysql_close();
?>