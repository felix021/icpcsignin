<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."team/inc.php");
$id = (int)$_SESSION['team_id'];

$ref = basename($_SERVER['HTTP_REFERER']);
if($ref == "index.php" || $ref == "unsetteam.php"){
    if (team::delById($id)){
        unset($_SESSION['team_id']);
        include(APP_ROOT."include/header.php");
        echo <<<eot
<script>
alert("队伍数据已经删除!");
window.top.location = "../index.php";
eot;
    }else{
        msgbox("删除队伍失败");
    }
}else{
    msgbox("入口错误! 请从队伍管理界面点击删除队伍");
}
?>
