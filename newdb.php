<meta content='text/html; charset=utf-8' http-equiv='Content-Type'>

<?php include('common.php'); ?>

<?php
mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($db_name);
$sql = "DROP TABLE `cangku`, `cangkushuju`, `chejian`, `dafenlei`, `shengchan`, `user`, `xiaofenlei`;

		CREATE TABLE user (ID int NOT NULL AUTO_INCREMENT, PRIMARY KEY(ID),
		name text,pass text,quanxian int,ck int,cj int,time int,del int DEFAULT '0',deluser int DEFAULT '0',`deltime` INT) CHARSET utf8 COLLATE utf8_general_ci;

		CREATE TABLE dafenlei (ID int NOT NULL AUTO_INCREMENT, PRIMARY KEY(ID),
		name text,quanxian int,del int DEFAULT '0',deluser int DEFAULT '0',`deltime` INT) CHARSET utf8 COLLATE utf8_general_ci;

		CREATE TABLE xiaofenlei (ID int NOT NULL AUTO_INCREMENT, PRIMARY KEY(ID),
		name text,dafenlei int,del int DEFAULT '0',deluser int DEFAULT '0',`deltime` INT) CHARSET utf8 COLLATE utf8_general_ci;
		CREATE TABLE cangku (ID int NOT NULL AUTO_INCREMENT, PRIMARY KEY(ID),		name text,user int,del int DEFAULT '0',deluser int DEFAULT '0',`deltime` INT) CHARSET utf8 COLLATE utf8_general_ci;

		CREATE TABLE cangkuweizi (ID int NOT NULL AUTO_INCREMENT, PRIMARY KEY(ID),ckid INT,name text) CHARSET utf8 COLLATE utf8_general_ci;

		CREATE TABLE cangkushuju (ID int NOT NULL AUTO_INCREMENT, PRIMARY KEY(ID),
		ckid int,ckwz int,dflid int,xflid int,num int,cjid int,gys text,userid int,time int,lx int,lyr int,bz text,del int DEFAULT '0',deluser int DEFAULT '0',`deltime` INT) CHARSET utf8 COLLATE utf8_general_ci;

		CREATE TABLE chejian (ID int NOT NULL AUTO_INCREMENT, PRIMARY KEY(ID),
		name text,del int DEFAULT '0',deluser int DEFAULT '0',`deltime` INT) CHARSET utf8 COLLATE utf8_general_ci;

		CREATE DATABASE IF NOT EXISTS yourdbname DEFAULT CHARSET utf8 COLLATE utf8_general_ci;
		
		CREATE TABLE shengchan (ID int NOT NULL AUTO_INCREMENT, PRIMARY KEY(ID),
		cjid int,dflid int,xflid int,num int,cpnum int,kcnum int,userid int,time int,del int DEFAULT '0',deluser int DEFAULT '0',`deltime` INT) CHARSET utf8 COLLATE utf8_general_ci;
		INSERT INTO user (name,pass,quanxian,time) VALUES ('admin','5e3ac6781aff698bf6f4e75fd214a9e7',777,'$time');
	";
$query_e = explode(';',$sql);
foreach ($query_e as $k =>$v)
{
	mysql_query($query_e[$k]);
}
mysql_close();
?>