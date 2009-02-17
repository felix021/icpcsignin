<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."admin/inc.php");

$team_id = (int)$_GET['team_id'];
if(team::delById($team_id)){
    msgbox("删除成功!");
}else{
    msgbox("删除失败!");
}
?>
