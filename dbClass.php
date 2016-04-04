<?php
include 'db.php';
function yzuser($name = null, $pass = null, $act = null)
{
    //echo "user:",$user,"|pass:",$pass,"|";
    if ($act == 'logout') {
        setcookie('name', '');
        setcookie('pass', '');
        setcookie('quanxian', '');
        setcookie('ck', '');
        setcookie('cj', '');
        return 'success';
    }
    if (condb()) {
        $sql    = 'SELECT * FROM user WHERE `name` = \'' . $name . '\' AND `pass`=\'' . $pass . '\'';
        $result = mysql_query($sql);
        if (mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_array($result)) {
                global $user_info;
                $user_info = $row;
                setcookie('name', $row['name']);
                setcookie('pass', $row['pass']);
                setcookie('quanxian', $row['quanxian']);
                setcookie('ck', $row['ck']);
                setcookie('cj', $row['cj']);
            }
            $time = time();
            $sql  = 'UPDATE user SET `time` = \'' . $time . '\' WHERE `name` = \'' . $name . '\' AND `pass` = \'' . $pass . '\'';
            mysql_query($sql);
            mysql_close();
            return 'success';
        } else {
            setcookie('name', '');
            setcookie('pass', '');
            setcookie('quanxian', '');
            setcookie('ck', '');
            setcookie('cj', '');
            return 'oh!no';
        }
    }
}
//
function adduser($name, $pass, $quanxian, $ck = null, $cj = null, $id = null)
{
    $time = time();
    //echo $name,"|",$id;
    if (condb()) {
        $sql    = 'SELECT * FROM user WHERE `name` = \'' . $name . '\'';
        $result = mysql_query($sql);
        if (mysql_num_rows($result) > 0 and $id == null) {
            $result = 0;
        } else {
            $sql = "INSERT INTO user (name,pass,quanxian,ck,cj,time) VALUES ('{$name}','{$pass}',{$quanxian},'{$ck}','{$cj}',{$time}); ";
            if ($id != null) {
                $sql = "UPDATE `user` SET `name` = '{$name}' ,";
                if ($pass != 'd41d8cd98f00b204e9800998ecf8427e') {
                    $sql = $sql . "`pass` = '{$pass}' ,";
                }
                $sql = $sql . "`quanxian` = {$quanxian} ,`ck` = '{$ck}',`cj` = '{$cj}' ,`time` = '{$time}' WHERE `user`.`ID` = {$id};";
            }
            //echo $sql;
            mysql_query($sql);
            $result = mysql_affected_rows();
            if ($id != null and $result == 1) {
                $result = 2;
            }
        }
    }
    mysql_close();
    return $result;
}
function getuser($qx)
{
    switch ($qx) {
        case '1':
            $sql = 'SELECT * FROM user';
            break;
        case '2':
            $sql = 'SELECT * FROM user WHERE `quanxian`=\'777\'';
            break;
        case '3':
            $sql = 'SELECT * FROM user WHERE `quanxian`=\'666\'';
            break;
        case '4':
            $sql = 'SELECT * FROM user WHERE `quanxian`=\'555\'';
            break;
        case '5':
            $sql = 'SELECT * FROM user WHERE `quanxian`=\'999\'';
    }
    if (condb()) {
        $result = mysql_query($sql);
        while ($row = mysql_fetch_assoc($result)) {
            $results[$row['ID']] = $row;
        }
    }
    mysql_close();
    return $results;
}
function deluser($id)
{
    if (condb()) {
        $sql = "DELETE FROM `user` WHERE `ID` = {$id}";
        mysql_query($sql);
    }
    mysql_close();
}
//
function addfenlei($name, $quanxian = null, $dfl = null, $id = null)
{
    if ($id == null) {
        $sql = "INSERT INTO dafenlei (name,quanxian) VALUES ('{$name}',{$quanxian}); ";
        if ($dfl != null) {
            $sql = "INSERT INTO xiaofenlei (name,dafenlei) VALUES ('{$name}',{$dfl}); ";
        }
    } else {
        $sql = "UPDATE `dafenlei` SET `name` = '{$name}' ,`quanxian` = {$quanxian} WHERE `dafenlei`.`ID` = {$id};";
        if ($dfl != null) {
            $sql = "UPDATE `xiaofenlei` SET `name` = '{$name}' ,`dafenlei` = {$dfl} WHERE `xiaofenlei`.`ID` = {$id};";
        }
    }
    //echo $sql;
    if (condb()) {
        mysql_query($sql);
        $new_id = mysql_insert_id();
    }
    if ($dfl != 999999) {
        mysql_close();
    }
    return $new_id;
}
function getfenlei($dfl = null)
{
    $sql = 'SELECT * FROM dafenlei WHERE `del`=0';
    if ($dfl != null) {
        $sql = "SELECT * FROM xiaofenlei WHERE `dafenlei`={$dfl} AND `del`=0";
        if ($dfl == 999999) {
            $sql = 'SELECT * FROM xiaofenlei';
        }
    }
    if (condb()) {
        $result = mysql_query($sql);
        while ($row = mysql_fetch_assoc($result)) {
            $results[$row['ID']] = $row;
        }
    }
    //echo $sql;
    //exit;
    mysql_close();
    return $results;
}
function delfenlei($dfl = null, $flid = null)
{
    if (condb()) {
        $time = time();
        global $user_info;
        $userid = $user_info['ID'];
        //$sql = "DELETE FROM `dafenlei` WHERE `ID` = $dfl";
        $sql[1] = "UPDATE `dafenlei` SET `del` = 1 ,`deltime` = {$time} ,`deluser` = {$userid} WHERE `dafenlei`.`ID` = {$dfl};";
        $sql[2] = "UPDATE `sengchan` SET `del` = 1 ,`deltime` = {$time} ,`deluser` = {$userid} WHERE `sengchan`.`dflid` = {$dfl};";
        $sql[3] = "UPDATE `cangkushuju` SET `del` = 1 ,`deltime` = {$time} ,`deluser` = {$userid} WHERE `cangkushuju`.`dflid` = {$dfl};";
        if ($flid != null) {
            $sql = null;
            //$sql = "DELETE FROM `xiaofenlei` WHERE `ID` = $flid AND `dafenlei` = $dfl;";
            $sql[1] = "UPDATE `xiaofenlei` SET `del` = 1 ,`deltime` = {$time} ,`deluser` = {$userid} WHERE `xiaofenlei`.`ID` = {$flid} AND `xiaofenlei`.`dafenlei` = {$dfl};";
            $sql[2] = "UPDATE `sengchan` SET `del` = 1 ,`deltime` = {$time} ,`deluser` = {$userid} WHERE `sengchan`.`xflid` = {$flid};";
            $sql[3] = "UPDATE `cangkushuju` SET `del` = 1 ,`deltime` = {$time} ,`deluser` = {$userid} WHERE `cangkushuju`.`xflid` = {$flid};";
        }
        //echo $sql;
        foreach ($sql as $v) {
            mysql_query($v);
        }
    }
    mysql_close();
}
//
function addcangku($name, $id = null, $ckid = null)
{
    if ($ckid == null) {
        $sql = "INSERT INTO cangku (name) VALUES ('{$name}');";
        if ($id != null) {
            $sql = "UPDATE `cangku` SET `name` = '{$name}' WHERE `cangku`.`ID` = {$id};";
        }
    } else {
        $sql = "INSERT INTO cangkuweizi (ckid,name) VALUES ({$ckid},'{$name}') ;";
        if ($id != null) {
            $sql = "UPDATE `cangkuweizi` SET `name` = '{$name}' WHERE `cangkuweizi`.`ID` = {$id};";
        }
    }
    echo $sql;
    //exit;
    if (condb()) {
        mysql_query($sql);
    }
    mysql_close();
}
function getcangku($id = null, $user = null, $ckid = null)
{
    $page = $_GET['page'];
    $sql  = 'SELECT * FROM `cangku` WHERE `del`=0 ORDER BY  `cangku`.`ID` ASC';
    if ($ckid != null) {
        $sql = "SELECT * FROM `cangkuweizi` WHERE `ckid` = {$ckid} ORDER BY  `cangkuweizi`.`ID` DESC";
    }
    if ($id != null) {
        $sql = "SELECT * FROM `cangkushuju` WHERE `ckid` = {$id} AND `del`=0 ORDER BY  `cangkushuju`.`ID` DESC";
        if ($user != null) {
            $sql = $sql . " AND `userid` = {$user}";
        }
        global $system_page;
        $in  = ($page - 1) * $system_page;
        $sql = $sql . " LIMIT {$in} , {$system_page}";
    }
    //echo $sql;
    if (condb()) {
        $result = mysql_query($sql);
        if ($result) {
            while ($row = mysql_fetch_assoc($result)) {
                $results['data'][$row['ID']]                   = $row;
                $results['flid'][$row['dflid']][$row['xflid']] = array($row['dflid'], $row['xflid']);
                $flidxxx[$row['xflid']]                        = array($row['dflid'], $row['xflid']);
            }
        }
        foreach ($flidxxx as $avx) {
            //var_dump($avx);
            if ($avx[1] > 0) {
                $numck                                      = "SELECT SUM(`num`) FROM  `cangkushuju` WHERE `dflid` = {$avx['0']} AND `xflid` = {$avx['1']} AND `del`=0";
                $axx                                        = mysql_query($numck);
                $rs                                         = mysql_fetch_array($axx);
                $cknum                                      = $rs[0];
                $results['flid'][$avx[0]][$avx[1]]['cknum'] = $cknum;
            }
        }
        if ($id != null) {
            global $sjnum;
            $numcx = "SELECT COUNT( * ) FROM  `cangkushuju` WHERE `ckid` = {$id} AND `del`=0";
            $axx   = mysql_query($numcx);
            $rs    = mysql_fetch_array($axx);
            $sjnum = $rs[0];
        }
    }
    mysql_close();
    return $results;
}
function delcangku($id)
{
    if (condb()) {
        $time = time();
        global $user_info;
        $userid = $user_info['ID'];
        $sql[1] = "UPDATE `cangku` SET `del` = 1 ,`deltime` = {$time} ,`deluser` = {$userid} WHERE `cangku`.`ID` = {$id}";
        $sql[2] = "UPDATE `cangkushuju` SET `del` = 1 ,`deltime` = {$time} ,`deluser` = {$userid} WHERE `cangkushuju`.`ckid` = {$id};";
        foreach ($sql as $v) {
            mysql_query($v);
        }
    }
    mysql_close();
}
//
function addchejian($name, $id = null)
{
    $sql = "INSERT INTO chejian (name) VALUES ('{$name}');";
    if ($id != null) {
        $sql = "UPDATE `chejian` SET `name` = '{$name}' WHERE `chejian`.`ID` = {$id};";
    }
    if (condb()) {
        mysql_query($sql);
    }
    mysql_close();
}
function getchejian($id = null, $user = null)
{
    $page = $_GET['page'];
    $sql  = 'SELECT * FROM `chejian` WHERE `del`=0 ORDER BY  `chejian`.`ID` ASC';
    if ($id != null) {
        $sql = "SELECT * FROM `shengchan` WHERE `cjid` = {$id} AND `del`=0 ORDER BY  `shengchan`.`ID` DESC";
        if ($user != null) {
            $sql = $sql . " AND `userid` = {$user}";
        }
        global $system_page;
        $in  = ($page - 1) * $system_page;
        $sql = $sql . " LIMIT {$in} , {$system_page}";
    }
    //echo $sql;
    if (condb()) {
        $result = mysql_query($sql);
        while ($row = mysql_fetch_assoc($result)) {
            $results[$row['ID']] = $row;
        }
        if ($id != null) {
            global $sjnum;
            $numcx = "SELECT COUNT( * ) FROM  `shengchan` WHERE  `cjid` = {$id} AND `del`=0";
            $axx   = mysql_query($numcx);
            $rs    = mysql_fetch_array($axx);
            $sjnum = $rs[0];
        }
    }
    mysql_close();
    return $results;
}
function delchejian($id)
{
    if (condb()) {
        $time = time();
        global $user_info;
        $userid = $user_info['ID'];
        $sql[1] = "UPDATE `chejian` SET `del` = 1 ,`deltime` = {$time} ,`deluser` = {$userid} WHERE `chejian`.`ID` = {$id}";
        $sql[2] = "UPDATE `cangkushuju` SET `del` = 1 ,`deltime` = {$time} ,`deluser` = {$userid} WHERE `cangkushuju`.`cjid` = {$id};";
        $sql[2] = "UPDATE `shengchan` SET `del` = 1 ,`deltime` = {$time} ,`deluser` = {$userid} WHERE `shengchan`.`cjid` = {$id};";
        foreach ($sql as $v) {
            mysql_query($v);
        }
    }
    mysql_close();
}
//
function addcangkushuju($ckid, $ckwz, $num, $dfl, $xfl, $cj, $gys, $userid, $id = null)
{
    $time = time();
    if (condb()) {
        $sql = "INSERT INTO cangkushuju (ckid,ckwz,dflid,xflid,num,cjid,gys,userid,time,lx,lyr,bz) VALUES ({$ckid},{$ckwz},{$dfl},{$xfl},{$num},{$cj},'{$gys}',{$userid},{$time},{$lx},{$lyr},{$bz});";
        //var_dump($sql);
        if ($id != null) {
            $sql = "UPDATE `cangkushuju` SET `ckid` = {$ckid} ,`ckwz` = {$ckwz} ,`dflid` = {$dfl} ,`xflid` = {$xfl} ,`num` = {$num} ,`cjid` = {$cj} ,`gys` = '{$gys}' ,`userid` = {$userid} ,`time` = {$time} WHERE `cangkushuju`.`ID`={$id}";
        }
        mysql_query($sql);
    }
    mysql_close();
}
function new_addcksj($ckid,$data,$id = null)
{
    $time = time();
    //$ckid = $data['ckid'];
    $ckwz = $data['ckwz'];$dfl = $data['dfl'];$xfl = $data['xfl'];$num = $data['num'];$cj = $data['cj'];
    $gys = $data['gys'];$userid = $data['userid'];$lx = $data['churuku'];$lyr = $data['lyr'];$bz = $data['bz'];
    if (condb()) {
        $sql = "INSERT INTO cangkushuju (ckid,ckwz,dflid,xflid,num,cjid,gys,userid,time,lx,lyr,bz) 
        VALUES ({$ckid},{$ckwz},{$dfl},{$xfl},{$num},{$cj},'{$gys}',{$userid},{$time},{$lx},{$lyr},'{$bz}');";
        //var_dump($sql);
        if ($id != null) {
            //$sql = "UPDATE `cangkushuju` SET `ckid` = {$ckid} ,`ckwz` = {$ckwz} ,`dflid` = {$dfl} ,`xflid` = {$xfl} ,`num` = {$num} ,`cjid` = {$cj} ,`gys` = '{$gys}' ,`userid` = {$userid} ,"
            $sql = "UPDATE `cangkushuju` SET `ckid` = {$ckid} ,`ckwz` = {$ckwz} ,`dflid` = {$dfl} ,`xflid` = {$xfl} ,`num` = {$num} ,`cjid` = {$cj} ,`gys` = '{$gys}' ,`userid` = {$userid} ,`time` = {$time} ,`lx` = {$lx} ,`lyr` = {$lyr} ,`bz` = '{$bz}' WHERE `cangkushuju`.`ID`={$id}";
        }
        mysql_query($sql);
    }
    //echo $sql;
    //exit;
    mysql_close();
}
function delcangkushuju($id)
{
    if (condb()) {
        $time = time();
        global $user_info;
        $userid = $user_info['ID'];
        //$sql = "DELETE FROM `cangkushuju` WHERE `ID` = $id";
        $sql = "UPDATE `cangkushuju` SET `del` = 1 ,`deltime` = {$time} ,`deluser` = {$userid} WHERE `cangkushuju`.`ID` = {$id}";
        mysql_query($sql);
    }
    mysql_close();
}
//
function addshengchan($cjid, $dflid, $xflid, $xflname = null, $data, $userid, $id = null)
{
    $time = time();
    //echo $xflid,"<br/>";
    //echo $xflname,"<br/>";
    if (condb()) {
        //exit;
        $num   = $data['num'];
        $cpnum = $data['cpnum'];
        $kcnum = $data['kcnum'];
        if ($xflid == 0) {
            if ($dflid == 999999) {
                $cxcf     = "SELECT * FROM `xiaofenlei` WHERE name='{$xflname}' AND dafenlei=999999 limit 1";
                $xflid_re = mysql_query($cxcf);
                if (mysql_num_rows($xflid_re) > 0) {
                    $re_a = mysql_fetch_array($xflid_re);
                    //var_dump($re_a['ID']);
                    $xflid = $re_a['ID'];
                } else {
                    $xflid = addfenlei($xflname, '', $dflid);
                }
            }
        }
        $sql = "INSERT INTO shengchan (cjid,dflid,xflid,num,cpnum,kcnum,userid,time) VALUES ({$cjid},{$dflid},{$xflid},{$num},{$cpnum},{$kcnum},{$userid},{$time});";
        if ($id != null) {
            $sql = "UPDATE `shengchan` SET `cjid` = {$cjid} ,`dflid` = {$dflid} ,`xflid` = {$xflid} ,`num` = {$num} ,`cpnum` = {$cpnum} ,`kcnum` = {$kcnum} ,`userid` = {$userid} ,`time` = {$time} WHERE `shengchan`.`ID`={$id}";
        }
        //echo $sql;
        mysql_query($sql);
    }
    mysql_close();
}
function delshengchan($id)
{
    if (condb()) {
        $time = time();
        global $user_info;
        $userid = $user_info['ID'];
        //$sql = "DELETE FROM `shengchan` WHERE `ID` = $id";
        $sql = "UPDATE `shengchan` SET `del` = 1 ,`deltime` = {$time} ,`deluser` = {$userid} WHERE `shengchan`.`ID` = {$id}";
        //echo $sql;
        mysql_query($sql);
    }
    mysql_close();
}
//
function getallxfl()
{
    $sql = 'SELECT * FROM `xiaofenlei`';
    if (condb()) {
        $result = mysql_query($sql);
        while ($row = mysql_fetch_assoc($result)) {
            $results[$row['ID']] = $row;
        }
    }
    mysql_close();
    return $results;
}
//
function qck($cpmc, $timein = null, $timeout = null)
{
    $timein  = strtotime($timein);
    $timeout = strtotime($timeout);
    if ($timein == null) {
        $timein = mktime(0, 0, 0, date('m'), 1, date('Y'));
    }
    if ($timeout == null) {
        $timeout = mktime(23, 59, 59, date('m'), date('t'), date('Y'));
    }
    $sql = "SELECT * FROM `cangkushuju` WHERE `time`>={$timein} and `time`<={$timeout} and `del`=0";
    if ($cpmc > 0) {
        $sql = $sql . " and `xflid` = {$cpmc}";
    }
    $sql = $sql . ' ORDER BY `ID` DESC';
    //echo $sql;
    if (condb()) {
        $result = mysql_query($sql);
        while ($row = mysql_fetch_assoc($result)) {
            //$results[$row['ID']] = $row;
            $results['data'][$row['ID']]                   = $row;
            $results['flid'][$row['dflid']][$row['xflid']] = array($row['dflid'], $row['xflid']);
            $flidxxx[$row['xflid']]                        = array($row['dflid'], $row['xflid']);
        }
    }
    foreach ($flidxxx as $avx) {
        //var_dump($avx);
        if ($avx[1] > 0) {
            $numck                                      = "SELECT SUM(`num`) FROM  `cangkushuju` WHERE `dflid` = {$avx['0']} AND `xflid` = {$avx['1']} AND `del`=0";
            $axx                                        = mysql_query($numck);
            $rs                                         = mysql_fetch_array($axx);
            $cknum                                      = $rs[0];
            $results['flid'][$avx[0]][$avx[1]]['cknum'] = $cknum;
        }
    }
    mysql_close();
    return $results;
}
//
function qcj($cpmc, $timein = null, $timeout = null)
{
    $timein  = strtotime($timein);
    $timeout = strtotime($timeout);
    if ($timein == null) {
        $timein = mktime(0, 0, 0, date('m'), 1, date('Y'));
    }
    if ($timeout == null) {
        $timeout = mktime(23, 59, 59, date('m'), date('t'), date('Y'));
    }
    $sql = "SELECT * FROM `shengchan` WHERE `time`>={$timein} and `time`<={$timeout} and `del`=0";
    if ($cpmc > 0) {
        $sql = $sql . " and `xflid` = {$cpmc}";
    }
    $sql = $sql . ' ORDER BY `ID` DESC';
    //echo $sql;
    if (condb()) {
        $result = mysql_query($sql);
        while ($row = mysql_fetch_assoc($result)) {
            $results['data'][$row['ID']] = $row;
        }
        $sql = "SELECT SUM(`num`)  FROM  `shengchan` WHERE `time`>={$timein} and `time`<={$timeout} and `del`=0";
        if ($cpmc > 0) {
            $sql = $sql . " and `xflid` = {$cpmc}";
        }
        $result                    = mysql_query($sql);
        $results['numdata']['num'] = mysql_result($result, 0);
        $sql                       = "SELECT SUM(`cpnum`)  FROM  `shengchan` WHERE `time`>={$timein} and `time`<={$timeout} and `del`=0";
        if ($cpmc > 0) {
            $sql = $sql . " and `xflid` = {$cpmc}";
        }
        $result                      = mysql_query($sql);
        $results['numdata']['cpnum'] = mysql_result($result, 0);
        $sql                         = "SELECT SUM(`kcnum`)  FROM  `shengchan` WHERE `time`>={$timein} and `time`<={$timeout} and `del`=0";
        if ($cpmc > 0) {
            $sql = $sql . " and `xflid` = {$cpmc}";
        }
        $result                      = mysql_query($sql);
        $results['numdata']['kcnum'] = mysql_result($result, 0);
    }
    mysql_close();
    return $results;
}
//
function getdel($dbname)
{
    $sql = "SELECT * FROM `{$dbname}` WHERE `del`=1 ORDER BY  `{$dbname}`.`ID` ASC";
    if (condb()) {
        $result = mysql_query($sql);
        //$results = array();
        while ($row = mysql_fetch_assoc($result)) {
            $results[$row['ID']] = $row;
        }
    }
    //echo $sql;
    //var_dump($results);
    mysql_close();
    return $results;
}
function hfdel($dbname, $id)
{
    $sql = "UPDATE `{$dbname}` SET `del` = 0 WHERE `{$dbname}`.`ID` = {$id}";
    if ($id == 'all') {
        $sql = "UPDATE `{$dbname}` SET `del` = 0 ,`deluser` = {$userid} WHERE `{$dbname}`.`del` = 1";
    }
    if (condb()) {
        mysql_query($sql);
    }
    mysql_close();
}
function deldel($dbname, $id)
{
    $sql = "DELETE FROM `{$dbname}` WHERE `{$dbname}`.`ID` = {$id}";
    if ($id == 'all') {
        $sql = "UPDATE FROM `{$dbname}` WHERE `{$dbname}`.`del` = 1";
    }
    if (condb()) {
        mysql_query($sql);
    }
    mysql_close();
}
function bzadd($zl,$db,$data){
	//添加数据
	if($zl==0){
		//$results.="";
		foreach($data as $x=>$x_value) {
			$qianmian .= $x.",";
			$houmian .=$x_value.",";
		}
		$qianmian == substr($qianmian,0,strlen($qianmian)-1) ;
		$houmian == substr($houmian,0,strlen($houmian)-1) ;
		$results = "INSERT INTO ".$db." (".$qianmian.") VALUES (".$houmian.")";
	}
	//修改数据
	if($zl==1){
		//INSERT INTO shengchan (cjid,dflid,xflid,num,cpnum,kcnum,userid,time) VALUES ({$cjid},{$dflid},{$xflid},{$num},{$cpnum},{$kcnum},{$userid},{$time});
	}
	return $results;
}