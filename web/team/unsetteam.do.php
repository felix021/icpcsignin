<?php
$relpath = dirname(__FILE__);
include($relpath."/def.php");

include(APP_ROOT."team/inc.php");
$id = (int)$_SESSION['team_id'];

$url = parse_url($_SERVER['HTTP_REFERER']);
$ref = basename($url['path']);
if($ref == "index.php" || $ref == "unsetteam.php"){
    if (team::delById($id)){
        unset($_SESSION['team_id']);
        include(APP_ROOT."include/header.php");
        $msg = <<<eot
<p>队伍已经删除</p>
<p><a href="$installDir/index.php">返回首页</a></p>
eot;
        msgbox($msg, false);
    }else{
        msgbox("删除队伍失败");
    }
}else{
    msgbox("入口错误! 请从队伍管理界面点击删除队伍");
}
?>
