<?php
include 'common.php';include 'dbClass.php';include 'admin-header.php';if($act==null){include 'indexClass.php';}else{include $act.'Class.php';}include 'admin-footer.php';?>