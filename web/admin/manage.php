<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."admin/verify.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
a{color:blue;text-decoration:none;}
a:hover{color:red;text-decoration:underline;}
.tre{padding:2px;background-color:#eee;}
.tro{padding:2px;background-color:#ddd;}
.tblhead{padding:2px;color:#fff;background-color:#000;}
td{text-align:center;padding:5px;}
body{margin:0px;}
</style>
</head>
<frameset frameborder="1" cols="15%,85%">
<frame name="actions" src="actions.php" />
<frame name="display" src="display.php" />
</frameset>
</html>
