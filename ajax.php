<?php
include "common.php";
include "dbClass.php";
$cz = $_GET['cz'];
switch ($cz) {
	case 'xfldq':
		$xfl_data = getfenlei($_GET['id']);
		$html = '<option value="0">自定义</option>';
		if($_GET['caiyy']=='ck'){
			$html = '<option value="0">请选择</option>';
		}
		foreach ($xfl_data as $dd) {
		$html = $html."<option value=". $dd['ID'] .">". $dd['name'] ."</option>";	
		}
		echo $html;
		break;
	case 'xfldq_2':
		$xfl_data = getfenlei($_GET['id']);
		$html = '{data:[';
		foreach ($xfl_data as $dd) {
			$html = $html.'{title:"'.$dd['name'].'",id:"'.$dd['ID'].'"},';
		//$html = $html."<option value=". $dd['ID'] .">". $dd['name'] ."</option>";	
		}
		$html = $html.']';
		echo $html;
		break;
}
?>