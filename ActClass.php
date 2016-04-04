<?php
/*
//php获取今日开始时间戳和结束时间戳
$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
//php获取昨日起始时间戳和结束时间戳
$beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
$endYesterday=mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
//php获取上周起始时间戳和结束时间戳
$beginLastweek=mktime(0,0,0,date('m'),date('d')-date('w')+1-7,date('Y'));
$endLastweek=mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y'));
//php获取本月起始时间戳和结束时间戳
$beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
*/
function time_ri(){
	$in = mktime(0,0,0,date('m'),date('d'),date('Y'));
	$out = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
	$time = array('in' => "$in" , 'out' => "$out");
	return $time;
}
function time_zhou(){
	$in = mktime(0,0,0,date('m'),date('d')-date('w')+1-7,date('Y'));
	$out = mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y'));
	$time = array('in' => "$in" , 'out' => "$out");
	return $time;
}
function time_yue(){
	$in = mktime(0,0,0,date('m'),1,date('Y'));
	$out = mktime(23,59,59,date('m'),date('t'),date('Y'));
	$time = array('in' => "$in" , 'out' => "$out");
	return $time;
}
function V($data){
	echo $data;
}
?>